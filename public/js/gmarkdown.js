var reg_rep = [
    {
        'reg': /\n{2,}/g,
        'rep': '\n<br>\n'
    },
    {
        'reg': /#{5,}\s(.*)/g,
        'rep': "<h5>$1</h5>"
    },
    {
        'reg': /#{4,}\s(.*)/g,
        'rep': "<h4>$1</h4>"
    },
    {
        'reg': /#{3,}\s(.*)/g,
        'rep': "<h3>$1</h3>"
    },
    {
        'reg': /#{2,}\s(.*)/g,
        'rep': "<h2>$1</h2>"
    },
    {
        'reg': /#\s(.*)/g,
        'rep': "<h1>$1</h1>"
    },
    {
        'reg': /\*{2}(.*)\*{2}/g,
        'rep': "<b>$1</b>"
    },
    {
        'reg': /((-\s.*\n)+)/g,
        'rep': "<ol>\n$&</ol>\n"
    },
    {
        'reg': /-\s(.*)\n*/g,
        'rep': "<li>$1</li>"
    },
    {
        'reg': /\[(.*)\]\((.*)\)/g,
        'rep': "<a href=$2>$1</a>"
    },
    {
        'reg': /```(.+)\n(?:.*\n*)+?```\n*/g,
        'rep': "<pre class=language-$1><code class=language-$1>\n<@@code@@>\n</code></pre>"
    },
    {
        'reg': /([^(<.+>)]+)\n/g,
        'rep': "<p>$1</p>"
    },
];
function MarkdownTable() {
    this.table_reg = /(\|.+\|\n?){2,}/g;
    this.parseTable = function (value) {
        String.prototype.gTrim = function () {
            return this.replace(/^[\s\uFEFF\xA0\|]+|[\s\uFEFF\xA0\|]+$/g, '');
        };
        var table = value.match(this.table_reg);
        if (table == null) {
            return;
        }
        table.forEach(function (element) {
            var tableHead = '<table class="table table-bordered table-hover"><thead><tr>';
            var rows = element.split('\n');
            //第一行为表头
            var headEle = rows.shift();
            var head = headEle.gTrim().split('|');
            var colsNum = 0;//记录多少列
            for (var key in head) {
                tableHead += '<th>' + head[key].gTrim() + '</th>';
                colsNum++;
            }
            tableHead += '</tr></thead>';
            reg_rep.push({
                'reg': new RegExp(headEle.replace(/\|/g, '\\\|') + '\n'),
                'rep': tableHead
            });
            //rows.shift();//去掉|---|---|---|
            var rowCnt = 0;
            var row;
            while (row = rows.shift()) {
                if (row == "") {
                    return;
                }
                var tableBodyRow = '';
                if (rowCnt == 0) {
                    tableBodyRow = '<tbody><tr>';
                } else {
                    tableBodyRow = '<tr>';
                }
                var arrRow = row.gTrim().split('|');
                for (var i = 0; i < colsNum; i++) {
                    var tmp = typeof arrRow[i] === 'undefined' ? "" : arrRow[i].gTrim();
                    tableBodyRow += "<td>" + tmp + "</td>";
                }
                tableBodyRow += '</tr>';
                reg_rep.push({
                    'reg': new RegExp(row.replace(/\|/g, '\\\|') + '\n*'),
                    'rep': tableBodyRow
                });
                rowCnt++;
            }
            var tmp = reg_rep.pop();
            tmp.rep += '</tbody></table>';
            reg_rep.push(
                {
                    'reg': tmp.reg,
                    'rep': tmp.rep
                }
            );
        });
    }
}

function MarkdownCode() {
    this.code_reg = new RegExp('```.+\n((?:.*\n*)+?)```\n*', 'g');
    this.code_tmp_reg = new RegExp('<@@code@@>', 'g');
    this.code_rep = [];
    this.getCodeRep = function (value) {
        while(this.code_reg.exec(value) != null) {
            this.code_rep.push(RegExp.$1);
        }
    }
    this.setCodeRep = function (value) {
        var res;
        while((res = this.code_tmp_reg.exec(value)) != null) {
            var tmp = this.code_rep.shift();
            value = value.replace(res, tmp);
        }
        return value;
    }
}
function markdownParser(value) {
    var markdownTable = new MarkdownTable();
    markdownTable.parseTable(value);
    var markdownCode = new MarkdownCode();
    markdownCode.getCodeRep(value);
    reg_rep.forEach(function (element) {
        value = value.replace(element.reg, element.rep);
    });
    value = markdownCode.setCodeRep(value);
    return value;
}