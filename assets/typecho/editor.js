(function ($) {
    $.fn.extend({
        /* 按键盘实现插入内容 */
        shortcuts: function () {
            this.keydown(function (e) {
                var _this = $(this);
                e.stopPropagation();
                if (e.altKey) {
                    switch (e.keyCode) {
                        case 67:
                            _this.insertContent('[code]' + _this.selectionRange() + '[/code]');
                            break;
                    }
                }
            });
        },
        /* 插入内容 */
        insertContent: function (myValue, t) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd('character', wee + t);
                    t <= 0 ? sel.moveStart('character', wee - 2 * t - myValue.length) : sel.moveStart('character', wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            } else {
                this.value += myValue;
                this.focus();
            }
        },
        /* 选择 */
        selectionRange: function (start, end) {
            var str = '';
            var thisSrc = this[0];
            if (start === undefined) {
                if (/input|textarea/i.test(thisSrc.tagName) && /firefox/i.test(navigator.userAgent)) str = thisSrc.value.substring(thisSrc.selectionStart, thisSrc.selectionEnd);
                else if (document.selection) str = document.selection.createRange().text;
                else str = document.getSelection().toString();
            } else {
                if (!/input|textarea/.test(thisSrc.tagName.toLowerCase())) return false;
                end === undefined && (end = start);
                if (thisSrc.setSelectionRange) {
                    thisSrc.setSelectionRange(start, end);
                    this.focus();
                } else {
                    var range = thisSrc.createTextRange();
                    range.move('character', start);
                    range.moveEnd('character', end - start);
                    range.select();
                }
            }
            if (start === undefined) return str;
            else return this;
        }
    });
})(jQuery);

/* 新按钮 */
$(function() {
    const items = [
        {
            title: '删除线',
            id: 'wmd-html',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M17.154 14c.23.516.346 1.09.346 1.72 0 1.342-.524 2.392-1.571 3.147C14.88 19.622 13.433 20 11.586 20c-1.64 0-3.263-.381-4.87-1.144V16.6c1.52.877 3.075 1.316 4.666 1.316 2.551 0 3.83-.732 3.839-2.197a2.21 2.21 0 0 0-.648-1.603l-.12-.117H3v-2h18v2h-3.846zm-4.078-3H7.629a4.086 4.086 0 0 1-.481-.522C6.716 9.92 6.5 9.246 6.5 8.452c0-1.236.466-2.287 1.397-3.153C8.83 4.433 10.271 4 12.222 4c1.471 0 2.879.328 4.222.984v2.152c-1.2-.687-2.515-1.03-3.946-1.03-2.48 0-3.719.782-3.719 2.346 0 .42.218.786.654 1.099.436.313.974.562 1.613.75.62.18 1.297.414 2.03.699z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '~~删除线内容~~'
        },
        {
            title: '下划线',
            id: 'wmd-html',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '<u>下划线内容</u>'
        },
        {
            title: '脚注',
            id: 'wmd-html',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path d="M11 7V20H9V7H3V5H15V7H11ZM19.5507 6.5803C19.7042 6.43453 19.8 6.22845 19.8 6C19.8 5.55817 19.4418 5.2 19 5.2C18.5582 5.2 18.2 5.55817 18.2 6C18.2 6.07624 18.2107 6.14999 18.2306 6.21983L17.0765 6.54958C17.0267 6.37497 17 6.1906 17 6C17 4.89543 17.8954 4 19 4C20.1046 4 21 4.89543 21 6C21 6.57273 20.7593 7.08923 20.3735 7.45384L18.7441 9H21V10H17V9L19.5507 6.5803V6.5803Z" fill="rgba(153,153,153,1)"></path></svg>',
            type: 'wmd-button',
            text: '\n这是一个脚注[^1]。\n[^1]: 这是一个脚注示例。\n'
        },
        {
            title: 'html代码',
            id: 'wmd-html',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.178l-4.62-1.256-.328-3.544h2.27l.158 1.844 2.52.667 2.52-.667.26-2.866H6.96l-.635-6.678h11.35l-.227 2.21H8.822l.204 2.256h8.217l-.624 6.778L12 18.178zM3 2h18l-1.623 18L12 22l-7.377-2L3 2zm2.188 2L6.49 18.434 12 19.928l5.51-1.494L18.812 4H5.188z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n!!!\n<p align="center">居中</p>\n<p align="right">居右</p>\n<font size="5" color="red">颜色&大小</font>\n!!!\n'
        },
        {
            title: '复选框（空）',
            id: 'wmd-check1',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5Z" fill="rgba(153,153,153,1)"></path></svg>',
            type: 'wmd-button',
            text: '\n{ } 复选框\n'
        },
        {
            title: '复选框（选）',
            id: 'wmd-check2',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z" fill="rgba(153,153,153,1)"></path></svg>',
            type: 'wmd-button',
            text: '\n{x} 复选框\n'
        },
        {
            title: '短代码',
            id: 'wmd-short-code',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M24 12l-5.657 5.657-1.414-1.414L21.172 12l-4.243-4.243 1.414-1.414L24 12zM2.828 12l4.243 4.243-1.414 1.414L0 12l5.657-5.657L7.07 7.757 2.828 12zm6.96 9H7.66l6.552-18h2.128L9.788 21z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\`短代码\`'
        },
        {
            title: '长代码',
            id: 'wmd-long-code',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 12l-7.071 7.071-1.414-1.414L8.172 12 2.515 6.343 3.929 4.93 11 12zm0 7h10v2H11v-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n\`\`\`html\n    代码主体\n\`\`\`\n'
        },
        {
            title: '回复可见',
            id: 'wmd-hide-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M17.882 19.297A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066L1.392 2.808l1.415-1.415 19.799 19.8-1.415 1.414-3.31-3.31zM5.935 7.35A8.965 8.965 0 0 0 3.223 12a9.005 9.005 0 0 0 13.201 5.838l-2.028-2.028A4.5 4.5 0 0 1 8.19 9.604L5.935 7.35zm6.979 6.978l-3.242-3.242a2.5 2.5 0 0 0 3.241 3.241zm7.893 2.264l-1.431-1.43A8.935 8.935 0 0 0 20.777 12 9.005 9.005 0 0 0 9.552 5.338L7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592zm-9.084-9.084a4.5 4.5 0 0 1 4.769 4.769l-4.77-4.769z" fill="rgba(139,139,139,1)"/></svg>',
            type: 'wmd-button',
            text: '\n{cat_hide}\n   这里的内容回复后才能看见\n{/cat_hide}\n'
        },
        {
            title: '插入表格',
            id: 'wmd-table-button',
            svg: '<svg t="1668215446794" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2736" width="20" height="20"><path d="M182.701 915.991c-40.5 0-74.701-33.539-74.701-74.701V182.71c0-34.822 28.755-74.701 73.206-74.701h660.093c38.579 0 74.701 32.098 74.701 74.701v658.58c0 40.384-30.676 74.701-74.701 74.701H182.701z m478.41-73.826h180.115V667.193H661.111v174.972z m-226.475 0h151.992V667.193H434.636v174.972z m-253.43 0h178.948V667.193H181.206v174.972z m479.905-254.379h180.115V408.164H661.111v179.622z m-226.475 0h151.992V408.164H434.636v179.622z m-253.43 0h178.948V408.164H181.206v179.622z m0-406.808v148.746l660.129 2.225v-150.6l-660.129-0.371z" p-id="2737" fill="#999999"></path></svg>',
            type: 'origin_btn',
            text: '\n| 表头 | 表头 | 表头 |\n| :--: | :--: | :--: |\n| 表格 | 表格 | 表格 |\n| 表格 | 表格 | 表格 |\n| 表格 | 表格 | 表格 |\n'
        },
        {
            title: 'Emoji表情',
            id: 'wmd-emoji',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-7h2a3 3 0 0 0 6 0h2a5 5 0 0 1-10 0zm1-2a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm8 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'origin_btn',
            text: '\nEmoji表情\n'
        },
        {
            title: '音频',
            id: 'wmd-localmusic-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 3v14a4 4 0 1 1-2-3.465V5H9v12a4 4 0 1 1-2-3.465V3h13zM5 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm11 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n{cat_localmusic name="歌曲名" url="音频地址"}\n'
        },
        {
            title: '音乐',
            id: 'wmd-webmusic-button',
            svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6340"><path d="M789.333333 298.666667a170.666667 170.666667 0 0 1-170.666666-170.666667h-85.333334v416.426667A192 192 0 1 0 618.666667 704V318.506667A256 256 0 0 0 789.333333 384zM426.666667 810.666667a106.666667 106.666667 0 1 1 106.666666-106.666667 106.666667 106.666667 0 0 1-106.666666 106.666667z" p-id="6341"></path></svg>',
            type: 'wmd-button',
            text: '\n{Geek_webmusic id="音乐ID"}\n'
        },
        {
            title: '歌单',
            id: 'wmd-playlist-button',
            svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="774"><path d="M587.52 108.16A128 128 0 0 0 512 272.213333l33.706667 93.013334a275.84 275.84 0 0 0-85.333334 16.426666 192 192 0 1 0 130.986667 360.746667 170.666667 170.666667 0 0 0 101.973333-218.666667l-7.893333-21.333333a192 192 0 0 1-64 321.066667A256 256 0 0 1 445.44 341.333333a42.666667 42.666667 0 1 0-29.013333-80.213333 341.333333 341.333333 0 1 0 233.386666 641.706667A277.333333 277.333333 0 0 0 640 378.666667l-49.28-135.68A42.666667 42.666667 0 1 1 671.573333 213.333333a42.666667 42.666667 0 1 0 80-29.226666 128 128 0 0 0-164.053333-75.946667z m-25.173333 554.666667a106.666667 106.666667 0 0 1-72.96-200.533334 192 192 0 0 1 86.613333-10.666666l36.906667 101.333333a85.333333 85.333333 0 0 1-50.56 109.44z" p-id="775"></path></svg>',
            type: 'wmd-button',
            text: '\n{Geek_playlist id="歌单ID"}\n'
        },
        {
            title: '视频',
            id: 'wmd-video-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM8 5v14h8V5H8zM4 5v2h2V5H4zm14 0v2h2V5h-2zM4 9v2h2V9H4zm14 0v2h2V9h-2zM4 13v2h2v-2H4zm14 0v2h2v-2h-2zM4 17v2h2v-2H4zm14 0v2h2v-2h-2z" fill="rgba(153,153,153,1)"/></svg>',
            type: 'wmd-button',
            text: '\n{cat_video key="这里输入视频链接地址"}\n'
        },
        {
            title: '图库',
            id: 'wmd-photos-button',
            svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1181"><path d="M896 512A384 384 0 0 0 533.333333 129.066667h-21.333333A384 384 0 0 0 129.066667 490.666667v21.333333A384 384 0 0 0 490.666667 896h21.333333a384 384 0 0 0 384-362.666667v-21.333333z m-85.333333 0v13.013333a128 128 0 0 1-249.813334 23.893334A213.333333 213.333333 0 0 0 721.066667 298.666667 298.666667 298.666667 0 0 1 810.666667 512zM512 213.333333h13.013333a128 128 0 0 1 23.893334 249.813334A213.333333 213.333333 0 0 0 298.666667 302.933333 298.666667 298.666667 0 0 1 512 213.333333zM213.333333 512v-13.013333a128 128 0 0 1 249.813334-23.893334A213.333333 213.333333 0 0 0 302.933333 725.333333 298.666667 298.666667 0 0 1 213.333333 512z m298.666667 298.666667h-13.013333a128 128 0 0 1-23.893334-249.813334A213.333333 213.333333 0 0 0 725.333333 721.066667 298.666667 298.666667 0 0 1 512 810.666667z" p-id="1182"></path></svg>',
            type: 'wmd-button',
            text: '\n{photos}\n图集\n{/photos}\n'
        },
        {
            title: 'bilibili视频',
            id: 'wmd-bili-button',
            svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path d="M7.17157 2.75725L10.414 5.99936H13.585L16.8284 2.75725C17.219 2.36672 17.8521 2.36672 18.2426 2.75725C18.6332 3.14777 18.6332 3.78094 18.2426 4.17146L16.414 5.99936L18.5 5.99989C20.433 5.99989 22 7.56689 22 9.49989V17.4999C22 19.4329 20.433 20.9999 18.5 20.9999H5.5C3.567 20.9999 2 19.4329 2 17.4999V9.49989C2 7.56689 3.567 5.99989 5.5 5.99989L7.585 5.99936L5.75736 4.17146C5.36684 3.78094 5.36684 3.14777 5.75736 2.75725C6.14788 2.36672 6.78105 2.36672 7.17157 2.75725ZM18.5 7.99989H5.5C4.7203 7.99989 4.07955 8.59478 4.00687 9.35543L4 9.49989V17.4999C4 18.2796 4.59489 18.9203 5.35554 18.993L5.5 18.9999H18.5C19.2797 18.9999 19.9204 18.405 19.9931 17.6444L20 17.4999V9.49989C20 8.67146 19.3284 7.99989 18.5 7.99989ZM8 10.9999C8.55228 10.9999 9 11.4476 9 11.9999V13.9999C9 14.5522 8.55228 14.9999 8 14.9999C7.44772 14.9999 7 14.5522 7 13.9999V11.9999C7 11.4476 7.44772 10.9999 8 10.9999ZM16 10.9999C16.5523 10.9999 17 11.4476 17 11.9999V13.9999C17 14.5522 16.5523 14.9999 16 14.9999C15.4477 14.9999 15 14.5522 15 13.9999V11.9999C15 11.4476 15.4477 10.9999 16 10.9999Z" fill="rgba(153,153,153,1)"></path></svg>',
            type: 'wmd-button',
            text: '\n{cat_bili p="1" key="这里输入B站BV号"}\n'
        }
    ];
    items.forEach(_ => {
        let item = $(`<li class="${_.type}" id="${_.id}" title="${_.title}">${_.svg}</li>`);
        item.on('click', function () {
            if(_.type == 'wmd-button'){
                $('#text').insertContent(_.text);
            }
        });
        $('#wmd-button-row').append(item);
    });
});

/* 隐藏默认的插入按钮 */
$(function() {
    $('#wmd-hide-button').before('<li id="wmd-spacer2" class="wmd-spacer"></li>');
    $('#wmd-bili-button').after('<li class="wmd-spacer" id="wmd-spacer2"></li><button title="发表" style="box-shadow: unset;padding: 0.5rem;vertical-align: middle;line-height: 0.5rem;border: unset;margin: 0.2rem;border-radius: 20%!important;background: unset;" type="submit" class="btn primary" id="btn-submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.596 1.04l6.347 6.346a.5.5 0 0 1-.277.848l-1.474.23-5.656-5.656.212-1.485a.5.5 0 0 1 .848-.283zM4.595 20.15c3.722-3.331 7.995-4.328 12.643-5.52l.446-4.018-4.297-4.297-4.018.446c-1.192 4.648-2.189 8.92-5.52 12.643L2.454 18.01c2.828-3.3 3.89-6.953 5.303-13.081l6.364-.707 5.657 5.657-.707 6.364c-6.128 1.414-9.782 2.475-13.081 5.303L4.595 20.15zm5.284-6.03a2 2 0 1 1 2.828-2.828A2 2 0 0 1 9.88 14.12z" fill="rgba(153,153,153,1)"/></svg></button><hr id="emojistart" style="border: unset;">');
    var emojiall = "😀 😁 😂 😃 😄 😅 😆 😉 😊 😋 😎 😍 😘 😗 😙 😚 😇 😐 😑 😶 😏 😣 😥 😮 😯 😪 😫 😴 😌 😛 😜 😝 😒 😓 😔 😕 😲 😷 😖 😞 😟 😤 😢 😭 😦 😧 😨 😬 😰 😱 😳 😵 😡 😠";
    var emojiarr = emojiall.split(" ");
    var emoji = "<div class='emojiblock' style='display:none;'>";
        emojiarr.forEach(function(element) {
            emoji += "<span class='editor_emoji'>" + element + "</span>";
        });
    emoji += "</div>";
    $('#emojistart').after(emoji);
});
$(document).on('click', '.editor_emoji',function () {
    var emoji = $(this).text();
    $('#wmd-editarea textarea').insertContent(emoji);
    $('#wmd-editarea textarea').focus();
});

window.onload = function () {
    /* 样式栏 */
    $(document).ready(function(){
        if ($("#custom-field").length >0){
            /* Emoji表情 */
            $(document).on('click', '#wmd-emoji', function() {
                $('.emojiblock').slideToggle();
            });
            /* 插入表格 */
            $(document).on('click', '#wmd-table-button', function() {
                $('body').append(
                    '<div id="postPanel">'+
                    '<div class="wmd-prompt-background" style="position: fixed; top: 0px; z-index: 1000; opacity: 0.5; height: 100%; left: 0px; width: 100%;"></div>'+
                    '<div class="wmd-prompt-dialog">'+
                    '<div>'+
                    '<h3><label class="typecho-label">插入表格</label></h3>'+
                        '<label>表格行</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="A">'+
                        '<label>表格列</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="B">'+
                    '</div>'+
                    '<form>'+
                    '<button type="button" class="btn btn-s primary" id="wmd-table-button_ok">确定</button>'+
                    '<button type="button" class="btn btn-s" id="post_cancel">取消</button>'+
                    '</form>'+
                    '</div>'+
                    '</div>');
            });
            $(document).on('click', '#wmd-table-button_ok',function () {
				let row = $(".wmd-prompt-dialog input[name='A']").val();
				let column = $(".wmd-prompt-dialog input[name='B']").val();
				if (isNaN(row)) row = 3;
				if (isNaN(column)) column = 3;
				let rowStr = '';
				let rangeStr = '';
				let columnlStr = '';
				for (let i = 0; i < column; i++) {
					rowStr += '| 表头 ';
					rangeStr += '| :--: ';
				}
				for (let i = 0; i < row; i++) {
					for (let j = 0; j < column; j++) columnlStr += '| 表格 ';
					columnlStr += '|\n';
				}
				const textContent = `${rowStr}|\n${rangeStr}|\n${columnlStr}\n`;
                $('#text').insertContent(textContent);
                $('#postPanel').remove();
                $('#wmd-editarea textarea').focus();
            });
            /* 取消 */
            $(document).on('click','#post_cancel',function() {
                $('#postPanel').remove();
                $('#wmd-editarea textarea').focus();
            });
        }
    });
};
