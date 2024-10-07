<?php 
/**
 * 主题功能
 * 
 * @author 林厌
 * 
 * 2024/07/28
 * 
 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');
class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/assets/typecho/option.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/assets/typecho/editor.js' . "'></script>";

    }
}
function cat_check_XSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',  
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}
function cat_reply($text,$word = true)
{
    if (cat_check_XSS($text)) {
        $text = "该回复疑似异常，已被系统拦截！";
    }
    if($word == true){
        $text = strip_tags($text, "<img>");
    }else{
        $text = rtrim(strip_tags($text), "\n");
    }
    return $text;
}
function article_changetext($post, $login){
    $content = $post->content;
    $cid = $post->cid;
    $content = preg_replace('/{{([\s\S]*?)}{([\s\S]*?)}}/', '<span class="e" cat_title="${2}">${1}</span>' , $content);
    $content = preg_replace('/{localmusic url="([\s\S]*?)"}/', '<music><audio style="width:100%;" src="${2}" controls>浏览器不支持音频播放。</audio></music> ', $content);

    // 修改过
    $content = preg_replace('/{Geek_webmusic id="([\s\S]*?)"}/', '<Geek_webmusic><meting-js id="${1}" server="netease" type="playlist" mutex="true" preload="auto" list-folded="true"></meting-js></Geek_webmusic>', $content);
    
    $content = preg_replace('/{Geek_playlist id="([\s\S]*?)"}/', '<Geek_playlist><meting-js server="netease" type="playlist" id="${1}"></meting-js></Geek_playlist>', $content);
    
    $content = preg_replace('/{cat_video key="([\s\S]*?)"}/','<article_video><video width="100%" controls="controls"><source src="${1}" type="video/mp4"></video></article_video>',$content);
    $content = preg_replace('/{cat_bili p="([\s\S]*?)" key="([\s\S]*?)"}/', '<article_video><iframe src="https://www.bilibili.com/blackboard/html5mobileplayer.html?bvid=${2}&amp;page=${1}&amp;as_wide=1&amp;danmaku=0&amp;hasMuteButton=1" scrolling="no" border="0" frameborder="no" width="100%" height="280px" framespacing="0" allowfullscreen="true"></iframe></article_video>', $content);
    
    $content = preg_replace('/<p><article_video([\s\S]*?)<\/article_video><\/p>/', '<article_video${1}</article_video>', $content);
    
    $content = preg_replace('/{photos}([\s\S]*?){\/photos}/','<waterfall>${1}</waterfall>',$content);
    
    $content = preg_replace_callback(
        '/<p><waterfall>([\s\S]*?)<\/waterfall><\/p>/',
        function ($matches) {
            // $matches[1] 包含 <cat_waterfall> 和 </cat_waterfall> 之间的内容
            // 理论上，这里不应该包含<p>标签，因为它们被外层的<p>包裹了
            // 但如果出于某种原因您想要确保去除它们，可以这样做：
            $innerCleanedContent = preg_replace('/<p\b[^>]*>/i', '', $matches[1]); // 去除<p>标签
            $innerCleanedContent = preg_replace('/<\/p\s*>/i', '', $innerCleanedContent); // 去除</p>标签
            
            // 再去掉 $innerCleanedContent 中的 <br> 标签
            $cleanedContent = preg_replace('/<br\s*\/?>/i', '', $innerCleanedContent);
            
            // 返回去除了 <p> 和 <br> 标签的 <cat_waterfall>...</cat_waterfall> 结构
            // 但请注意，这里的<p>去除步骤可能是多余的
            return '<waterfall>' . $cleanedContent . '</waterfall>';
        },
        $content
    );
    
    
    $db = Typecho_Db::get();
    $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
    if ($hasComment || $login) {
        $content = strtr($content, array("{cat_hide}" => "<div class='cat_block'><div class='cat_article_show_word'>此处内容回复后可见，现已为您显示</div>", "{/cat_hide}" => "</div>"));
    } else {
        $content = preg_replace('/{cat_hide[^}]*}([\s\S]*?){\/cat_hide}/', '<cat_article_hide>此处内容，需回复之后可见</cat_article_hide>', $content);
    }
    $content = preg_replace('/<img src([\s\S]*?)title="([\s\S]*?)">/', '<post_image><img class="shadow-lg border-solid border-black border-2 roundedaA object-cover postimg isfancy lazyload" data-src${1}></post_image>', $content);
    
    // 这段代码的目的是在字符串$content中查找所有被<p>标签包裹的<cat_post_image>...</cat_post_image>自定义标签，并将它们替换为只保留<cat_post_image>...</cat_post_image>部分（移除了外层的<p>标签）。
    $content = preg_replace('/<p><post_image([\s\S]*?)<\/post_image><\/p>/', '<post_image$1</post_image>', $content);
    
    
    $content = preg_replace('/<p>([\s\S]*?)<\/p>/', '<p class="py-2">${1}</p>', $content);


    // 所有具有class、data-src、和alt属性的<img>标签，并将它们替换为一个<span>标签，该<span>标签包含了一个修改后的<img>标签，并且添加了一些新的属性（data-fancybox="gallery"和data-caption
    $content = preg_replace('/<img class="(.*?) object-cover rounded" width="100%" data-src="(.*?)" alt="(.*?)"(.*?)>/', '<span data-fancybox="gallery" data-caption="${3}"><img width="100%" data-src="${2}" class="shadow-lg border-solid border-black border-2 roundedaA ${1} object-cover" alt="${3}"></span>', $content); 
    // 修改原本的a链接
    $content = preg_replace('/<a href="([\s\S]*?)">([\s\S]*?)<\/a>/', '<a href="${1}" class="links" alt="${2}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.0607 8.11097L14.4749 9.52518C17.2086 12.2589 17.2086 16.691 14.4749 19.4247L14.1214 19.7782C11.3877 22.5119 6.95555 22.5119 4.22188 19.7782C1.48821 17.0446 1.48821 12.6124 4.22188 9.87874L5.6361 11.293C3.68348 13.2456 3.68348 16.4114 5.6361 18.364C7.58872 20.3166 10.7545 20.3166 12.7072 18.364L13.0607 18.0105C15.0133 16.0578 15.0133 12.892 13.0607 10.9394L11.6465 9.52518L13.0607 8.11097ZM19.7782 14.1214L18.364 12.7072C20.3166 10.7545 20.3166 7.58872 18.364 5.6361C16.4114 3.68348 13.2456 3.68348 11.293 5.6361L10.9394 5.98965C8.98678 7.94227 8.98678 11.1081 10.9394 13.0607L12.3536 14.4749L10.9394 15.8891L9.52518 14.4749C6.79151 11.7413 6.79151 7.30911 9.52518 4.57544L9.87874 4.22188C12.6124 1.48821 17.0446 1.48821 19.7782 4.22188C22.5119 6.95555 22.5119 11.3877 19.7782 14.1214Z"></path></svg><span>${2}</span></a>', $content);
    // 修改原本的引用
    $content = preg_replace('/<blockquote>([\s\S]*?)<\/blockquote>/', '<blockquote><div class="flex flex-col" ><span class="relative" style="background:#bad5ca;"></span><span class="relative" style="background:#f8e0b1"></span><span class="relative" style="background:#a8dee2"></span></div><u>${1}</u></blockquote>', $content);
    
    // 注脚修改
    
    $content = preg_replace('/<img src([\s\S]*?)title="([\s\S]*?)">/', '<cat_post_image><img class="postimg isfancy lazyload" data-src${1}></cat_post_image>', $content);
    

    // [\s\S]*?)：这是一个捕获组，用于匹配<cat_post_image>和</cat_post_image>之间的任何字符（包括换行符，因为[\s\S]匹配任何空白字符或非空白字符，即所有字符）
    // 
    echo $content;
}

function get_Abstract($item, $num)
{
	$abstract = "";
	if ($item->password) {
		$abstract = "⚠️此文章已加密";
	} else {
		if ($item->fields->abstract) {
			$abstract = $item->fields->abstract;
		} else {
			$abstract = strip_tags($item->excerpt);
			$abstract = preg_replace('/\-o\-/', '', $abstract);
            $abstract = preg_replace('/{[^{]+}/', '', $abstract);
		}
	}
	if ($abstract === '') $abstract = "⚠️此文章暂无简介";
	return mb_substr($abstract, 0, $num);
}
