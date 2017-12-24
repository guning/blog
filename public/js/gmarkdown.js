String.prototype.gTrim = function () {
    return this.replace(/^[\s\uFEFF\xA0\|]+|[\s\uFEFF\xA0\|]+$/g, '');
};
var reg_rep = [
    {
        'reg': /```(.+)\n((?:.*\n*)+?)```\n*/g,
        'rep': function (match, p1, p2) {
            return "<pre class=language-" + p1 + "><code class=language-" + p1 + ">" + p2.replace(/\n/g, '') + "</code></pre>\n";
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
        'reg': /^#{5,}\s(.*)$/gm,
        'rep': "<h5>$1</h5>"
    },
    {
        'reg': /^#{4,}\s(.*)$/gm,
        'rep': "<h4>$1</h4>"
    },
    {
        'reg': /^#{3,}\s(.*)$/gm,
        'rep': "<h3>$1</h3>"
    },
    {
        'reg': /^#{2,}\s(.*)$/gm,
        'rep': "<h2>$1</h2>"
    },
    {
        'reg': /^#\s(.*)$/gm,
        'rep': "<h1>$1</h1>"
    },
    {
        'reg': /\*{2}(.*)\*{2}/g,
        'rep': "<b>$1</b>"
    },
    {
        'reg': /((-\s.*\n)+)/g,
        'rep': "<ul>$&</ul>\n"
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