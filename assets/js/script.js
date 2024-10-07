/** - - - - - - - - - - - - - - - - - - 
            返回置顶            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function () {
    var showTopBtnThreshold = 300;
    $(window).scroll(function () {
        if ($(this).scrollTop() > showTopBtnThreshold) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').show();
        }
    });

    $('#back-to-top').click(function () {
        if ($(window).scrollTop() === 0) {
            $.message({
                message: '已经在顶部！',
                type: 'error'
            });
        } else {
            $('html, body').animate({ scrollTop: 0 }, 800);
            $.message({
                message: '成功返回顶部！',
                type: 'success'
            });
        }
        return false;
    });

    // 每隔一段时间检查是否能返回顶部
    setInterval(function () {
        if ($(window).scrollTop() === 0) {
            $('#back-to-top').removeClass('active border-gray-900 border-solid text-gray-900 bg-yellow-500');
        } else {
            $('#back-to-top').addClass('active border-gray-900 border-solid text-gray-900 bg-yellow-500');
        }
    }, 500);
});
/** - - - - - - - - - - - - - - - - - - 
            昼夜替换            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function () {
    // 检查是否存在夜间模式的 cookie
    let isNightMode;
            try {
                isNightMode = Cookies.get('nightMode') === 'true';
            } catch (error) {
                console.error('Error getting night mode from cookies:', error);
                // 可以在这里添加一个默认的模式或者提示用户
                isNightMode = false;
            }
            if (isNightMode) {
                $('body').addClass('night-mode');
                $('#toggle-night-mode ').addClass('active border-gray-900 border-solid text-gray-900 bg-yellow-500');
    }
    $('#toggle-night-mode').click(function () {
        const body = $('body');
        const button = $('#toggle-night-mode');
        if (body.hasClass('night-mode')) {
            // 当前是夜间模式，切换为白天模式
            body.removeClass('night-mode');
            button.removeClass('active border-gray-900 border-solid text-gray-900 bg-yellow-500');
            Cookies.set('nightMode', 'false');
            $.message({
                message: '关闭夜间模式',
                type: 'warning'
            });
        } else {
            // 当前是白天模式，切换为夜间模式
            body.addClass('night-mode');
            button.addClass('active border-gray-900 border-solid text-gray-900 bg-yellow-500');
            Cookies.set('nightMode', 'true');
            $.message({
                message: '切换至夜间模式',
                type: 'warning'
            });
        }
    });
});
/** - - - - - - - - - - - - - - - - - - 
            提醒            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function () {
    $('#toggle-notification').click(function () {
        $.message({
            message: '墨迹博主还未开发此功能',
            type: 'error'
        });
    });
});
/** - - - - - - - - - - - - - - - - - - 
            导航            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function () {
    function nav() {
        // 切换导航的显示和隐藏
        $('#toggle-nav').click(function (event) {
            var $navActive = $(".nav-active");
            var leftValue = parseInt($navActive.css("left"), 10);

            // 切换left值和display值
            $navActive.css("left", leftValue === -300 ? "0" : "-300px");

            // 使用console.log进行调试
            console.log('导航启动失败联系博主');
            event.stopPropagation(); // 阻止事件冒泡
        });

        // 点击其他地方恢复导航的left值
        $(document).click(function (event) {
            // 检查点击事件的目标是否属于.nav-active或其子元素
            if (!$(event.target).closest('.nav-active').length) {
                $(".nav-active").css("left", "-300px");
            }
        });
    }

    // 初始绑定事件
    nav();

    // 使用pjax时重新绑定事件
    $(document).on('pjax:success', function() {
        nav();
    });
});

/** - - - - - - - - - - - - - - - - - - 
            音乐            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function () {
    $('#toggle-music').click(function () {
        // 切换菜单内部类的显示状态
        $(".menu-inner").toggleClass("inner-none"); 
        $(this).toggleClass("active border-gray-900 border-solid text-gray-900 bg-yellow-500 "); 

        // 切换音乐播放器的高度
        var $musicActive = $(".music-active");
        var isCollapsed = $musicActive.css("height") === "0px";
        $musicActive.css("height", isCollapsed ? "100px" : "0px");

        // 切换底部控制元素的bottom属性
        var $bottomControl = $(".bottom-control"); // 确保这个选择器指向正确的元素
        var bottomValue = parseInt($bottomControl.css("bottom"), 10);
        $bottomControl.css("bottom", bottomValue === -40 ? "-15px" : "-40px");
        
        // 切换底部控制元素的bottom属性
        var $opacityControl = $("#nav-music"); // 确保这个选择器指向正确的元素
        var opacityValue = parseInt($opacityControl.css("opacity"), 10);
        $opacityControl.css("opacity", opacityValue === 1 ? "0" : "1");
        
    });
});

/**
 *------------------------------------------------------
 * 评论内容显示
 *------------------------------------------------------
 **/
$(document).ready(function() {
    function Comment() {
        $('.Comment_style').click(function(event) {
            event.stopPropagation(); // 阻止事件冒泡
            // 只显示当前被点击的 Comment_style 对应的 Comment_input 和 Comment_info
            $(this).closest('.element').find('.Comment_input, .Comment_info').slideDown();
        });

        $(document).click(function() {
            // 点击其他地方时，‌隐藏所有打开的 Comment_input 和 Comment_info
            $('.Comment_input, .Comment_info').slideUp();
        });

        // 防止点击 Comment_input 或 Comment_info 时触发隐藏
        $('.Comment_input, .Comment_info').click(function(event) {
            event.stopPropagation(); // 阻止事件冒泡到 document
        });
    }

    // 初始绑定事件
    Comment();

    // pjax重新绑定事件
    $(document).on('pjax:success', function() {
        Comment();
    });
});
/**
 *------------------------------------------------------
 * 1. 评论页面pre代码设置
 * 2. 评论页面链接和图片设置
 *------------------------------------------------------
 **/
$(document).ready(function() {
    function pre() {
        var $commentText = $('.commentText pre');
        
        $commentText.click(function(event) {
            event.stopPropagation(); // 阻止事件冒泡
            $commentText.css('max-height', '120px'); // 设置新的最大高度
        });

        $(document).click(function() {
            // 点击其他地方时，‌恢复最大高度限制
            $commentText.css('max-height', '80px');
        });
    }

    // 初始绑定事件
    pre();

    // pjax重新绑定事件
    $(document).on('pjax:success', function() {
        pre();
    });
});
$(document).ready(function() {
    // 定义一个函数来处理 DOM 修改和事件绑定
    function commentText() {
        // 为 .commentText 内的所有 <a> 标签添加 'links' 类
        $('.commentText').find('a').addClass('links');

        // 为 .commentText 内的所有 <img> 标签添加样式类
        $('.commentText').find('img').addClass('object-cover w-40 rounded transition postimg');

        // 修改 .commentText 内的所有 <a> 标签的 HTML
        $('.commentText').find('a').html(function(index, originalHTML) {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"></path><path d="M17.657 14.8284L16.2428 13.4142L17.657 12C19.2191 10.4379 19.2191 7.90526 17.657 6.34316C16.0949 4.78106 13.5622 4.78106 12.0001 6.34316L10.5859 7.75737L9.17171 6.34316L10.5859 4.92895C12.9291 2.5858 16.7281 2.5858 19.0712 4.92895C21.4143 7.27209 21.4143 11.0711 19.0712 13.4142L17.657 14.8284ZM14.8286 17.6569L13.4143 19.0711C11.0712 21.4142 7.27221 21.4142 4.92907 19.0711C2.58592 16.7279 2.58592 12.9289 4.92907 10.5858L6.34328 9.17159L7.75749 10.5858L6.34328 12C4.78118 13.5621 4.78118 16.0948 6.34328 17.6569C7.90538 19.219 10.438 19.219 12.0001 17.6569L13.4143 16.2427L14.8286 17.6569ZM14.8286 7.75737L16.2428 9.17159L9.17171 16.2427L7.75749 14.8284L14.8286 7.75737ZM5.77539 2.29291L7.70724 1.77527L8.74252 5.63897L6.81067 6.15661L5.77539 2.29291ZM15.2578 18.3611L17.1896 17.8434L18.2249 21.7071L16.293 22.2248L15.2578 18.3611ZM2.29303 5.77527L6.15673 6.81054L5.63909 8.7424L1.77539 7.70712L2.29303 5.77527ZM18.3612 15.2576L22.2249 16.2929L21.7072 18.2248L17.8435 17.1895L18.3612 15.2576Z"></path></svg>' + originalHTML;
        });
    }
    // 初始时调用 commentText 函数
    commentText();
    // 监听pjax成功事件，‌重新绑定事件和其他初始化操作
    $(document).on('pjax:success', function() {
        // 重新绑定评论内容图片链接事件
        commentText();
    });
});
/** - - - - - - - - - - - - - - - - - - 
            评论emoji            
- - - - - - - - - - - - - - - - - -  **/
$(document).ready(function() {
  // 定义一个函数来绑定点击事件
  function emoji() {
    // 点击 .emoji-btn 时切换类
    $('.emoji-btn').click(function(e) {
      e.stopPropagation(); // 阻止事件冒泡到 document

      // 只切换当前按钮关联的 .comment_emoji_block 的类
      var $emojiBlock = $(this).closest('.comment_emoji').find('.comment_emoji_block');
      $emojiBlock.toggleClass('active');

      // 切换当前按钮的类
      $(this).toggleClass('bg-secondaryB');
    });

    // 点击 document 时，‌如果 .comment_emoji_block 有 active 类，‌则移除
    $(document).click(function() {
      $('.comment_emoji_block').each(function() {
        if ($(this).hasClass('active')) {
          $(this).removeClass('active');
          // 找到对应的 .emoji-btn 并移除类
          $(this).closest('.comment_emoji').find('.emoji-btn').removeClass('bg-secondaryB');
        }
      });
    });
  }
  // 初始时调用 emoji 函数
  emoji();
  // 使用 PJAX 后重新绑定事件
  $(document).on('pjax:success', function() {
    emoji();
  });
});
/** - - - - - - - - - - - - - - - - - - 
            评论ajax            
- - - - - - - - - - - - - - - - - -  **/

$(document).ready(function() {
    function ajaxComment() {
        $('.comment-form').submit(function(event) {
            event.preventDefault(); // 阻止表单的默认提交行为

            var commentdata = $(this).serializeArray();
            var formAction = $(this).attr('action');
            var formMethod = $(this).attr('method');

            $.ajax({
                url: formAction,
                type: formMethod,
                data: commentdata,
                beforeSend: function() {
                    $.message({
                        message: '评论提交中请稍后~',
                        type: 'warning'
                    });
                },
                error: function(request) {
                    // 尝试从响应中提取错误信息，如果失败则显示默认错误
                    var errorMessage = request.responseText.split('<div class="container">').split('</div>');
                    $.message({
                        message: errorMessage || '评论提交失败，请稍后重试。',
                        type: 'error'
                    });
                },
                success: function(data) {
                    // 检查响应中是否包含错误标题
                    if (/<title>Error<\/title>/.test(data)) {
                        var errorMatch = data.match(/<div(.*?)>(.*?)<\/div>/is);
                        var errorMessage = '发生了未知错误';
                        if (errorMatch) {
                            errorMessage = errorMatch;
                        }
                        $.message({
                            message: '评论失败~ ' + errorMessage,
                            type: 'error'
                        });
                    } else {
                        $.message({
                            message: '评论成功',
                            type: 'success'
                        });

                        // 重置表单和评论列表
                        $('#submitComment').addClass('submit').text('提交');
                        $("#textarea").val('');
                        $('.comment').html($('.comment', data).html());
                        $('.Comments-lists').html($('.Comments-lists', data).html()); // 修正了这里的选择器

                        // 可选：移除或隐藏某个元素
                        $('#comment-parent').remove(); // 根据实际需求决定是否移除
                    }
                }
            });
        });
    }

    ajaxComment(); // 调用函数
    
});
/**
 *------------------------------------------------------
 * 站点音乐功能
 *------------------------------------------------------
 **/
var Pamper_musicPlaying = false;
var Pamper_musicFirst = false;
var navMusicEl = document.getElementById("nav-music");
var Pamper_music = {
  //切换音乐播放状态
  musicToggle: function (changePaly = true) {
    if (!Pamper_musicFirst) {
      musicBindEvent();
      Pamper_musicFirst = true;
    }
    let msgPlay = '<i class="fa-solid fa-play"></i><span>播放音乐</span>'; // 此處可以更改為你想要顯示的文字
    let msgPause = '<i class="fa-solid fa-pause"></i><span>暂停音乐</span>'; // 同上，但兩處均不建議更改
    if (Pamper_musicPlaying) {
      navMusicEl.classList.remove("playing");
      // 修改右键菜单文案为播放
      // document.getElementById("menu-music-toggle").innerHTML = msgPlay;
      document.getElementById("nav-music-hoverTips").innerHTML = "音乐已暂停";
      // document.querySelector("#consoleMusic").classList.remove("on");
      Pamper_musicPlaying = false;
      navMusicEl.classList.remove("stretch");
    } else {
      navMusicEl.classList.add("playing");
      // 修改右键菜单文案为暂停
      // document.getElementById("menu-music-toggle").innerHTML = msgPause;
      // document.querySelector("#consoleMusic").classList.add("on");
      Pamper_musicPlaying = true;
      navMusicEl.classList.add("stretch");
    }
    if (changePaly) document.querySelector("#nav-music meting-js").aplayer.toggle();
  },
  // 音乐伸缩
  musicTelescopic: function () {
    if (navMusicEl.classList.contains("stretch")) {
      navMusicEl.classList.remove("stretch");
    } else {
      navMusicEl.classList.add("stretch");
    }
  },

  //音乐上一曲
  musicSkipBack: function () {
    document.querySelector("#nav-music meting-js").aplayer.skipBack();
  },

  //音乐下一曲
  musicSkipForward: function () {
    document.querySelector("#nav-music meting-js").aplayer.skipForward();
  },

  //获取音乐中的名称
  musicGetName: function () {
    var x = $(".aplayer-title");
    var arr = [];
    for (var i = x.length - 1; i >= 0; i--) {
      arr[i] = x[i].innerText;
    }
    return arr[0];
  },
};
// 音乐绑定事件
function musicBindEvent() {
  document.querySelector("#nav-music .aplayer-music").addEventListener("click", function () {
    Pamper_music.musicTelescopic();
  });
  document.querySelector("#nav-music .aplayer-button").addEventListener("click", function () {
    Pamper_music.musicToggle(false);
  });
}
// 如果有右键事件 可以在这里写。
// addRightMenuClickEvent();



/** - - - - - - - - - - - - - - - - - - 
            pjax重置            
- - - - - - - - - - - - - - - - - -  **/
jQuery(document).ready(function($) {
    // 使用Pjax
    var pjax = new Pjax({
        selectors: [
            "title",
            "meta[name=description]",
            "main",
            "nav",
            "footer",
            ".pjax"
        ],
        cacheBust: false,
        analytics: false
    });

    // 显示加载提示的函数
    function showLoader() {
        // 添加一个带有样式的加载提示
        $('body').append('<div id="loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, .5); display: flex; align-items: center; justify-content: center; z-index: 9999;"><div style="padding: 20px; background-color: rgba(0, 0, 0, 1); border-radius: 5px; text-align: center;color:#fff;">加载中...</div></div>');
        // 禁用页面上的某些交互
        $('body').addClass('pjax-loading');
    }

    // 隐藏加载提示的函数
    function hideLoader() {
        $('#loader').remove();
        // 启用页面上的交互
        $('body').removeClass('pjax-loading');
    }

    // 监听PJAX事件
    $(document).on('pjax:send', showLoader);
    $(document).on('pjax:complete', hideLoader);
    $(document).on('pjax:error', function(event, xhr, textStatus, errorThrown) {
        hideLoader();
        // 可以在这里添加错误处理代码
    });

    // 监听pjax成功事件，‌重新绑定事件和其他初始化操作
    $(document).on('pjax:success', function() {
        // 隐藏加载提示
        hideLoader();
        // 重新高亮代码块
        Prism.highlightAll();
    });
});