String.prototype.gTrim = function () {
    return this.replace(/^[\s\uFEFF\xA0\|]+|[\s\uFEFF\xA0\|]+$/g, '');
};
var reg_rep = [
    {
        'reg': /((>\s.*\n)+)/g,
        'rep': function (match) {
            return '<blockquote><p>' + match.split('\n').map(i => i.substring(2)+'<br>').join('') + '</p></blockquote>';
        }
    },
    {
        'reg': /```(.+)\n((?:.*\n*)+?)```\n*/g,
        'rep': function (match, p1, p2) {
            return "<pre class=language-" + p1 + "><code class=language-" + p1 + ">" + p2 + "</code></pre>\n";
        }
    },
    {
        'reg': /((?:.+\|.+)+)\n(?:-+\|-+)+\n((?:(?:.+\|.+)+\n?)+)/g,
        'rep': function (match, p1, p2) {
            var table = '<table class="table table-bordered table-hover">';
            table += '<thead><tr><th>' + p1.gTrim().split('|').join('</th><th>') + '</th></tr></thead>';
            table += '<tbody>';
            var rows = p2.split('\n');
            var row;
            while (row = rows.shift()) {
                table += '<tr><td>' + row.gTrim().split('|').join('</td><td>') + '</td></tr>';
            }
            table += '</tbody></table>';
            return table;
        }
    },
    {
        'reg': /\n{2,}/g,
        'rep': '\n<br>\n'
    },
    {
        'reg': /^(#+)\s(.*)$/gm,
        'rep': function (match, p1, p2) {
            var l = p1.length > 5 ? 5 : p1.length;
            return '<div class="h' + l + '">' + p2 + '</div>';
        }
    },
    {
        'reg': /~{2}(.+)~{2}/g,
        'rep': "<del>$1</del>"
    },
    {
        'reg': /\*{2}(.*)\*{2}/g,
        'rep': "<b>$1</b>"
    },
    {
        'reg': /`(.+)`/g,
        'rep': "<code>$1</code>"
    },
    {
        'reg': /((-\s.*\n)+)/g,
        'rep': function (match) {
            return '<ul>' + match.replace(/^-\s(.*)$/gm, "<li>$1</li>") + '</ul>';
        }
    },
    {
        'reg': /\[(.*)\]\((.*)\)/g,
        'rep': "<a href=$2>$1</a>"
    },
    {
        'reg': /^(?!\<.+\>)(.*)$/gm,
        'rep': '<p>$1</p>'
    }
];

function markdownParser(value) {
    reg_rep.forEach(function (element) {
        value = value.replace(element.reg, element.rep);
    });
    return value;
}