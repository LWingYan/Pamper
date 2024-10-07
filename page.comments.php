<?php
/**
 * 
 * 动态 💭
 * 
 * @package custom
 * 
 * @author  林厌
 * 
 * @time 2024.8.24
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<main>
    <section>
        <h1 class="font-bold night:text-gray-100">
        <?php $this->options->title();?>
        </h1>
        <p style="margin-top:0.375em;" class="text-base text-gray-500"> 
        <?php $this->options->description() ;?>
        </p>
    </section>
    <section class="relative transition z-1">
        <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <div class="search-inner h-16 flex items-center border-solid border-2 border-black rounded-2xl mt-8 relative w-full text-base bg-white night:bg-white transition">
                <button type="submit" class="h-full bg-gray-100 w-20 transition border border-right-style searchA p-1 flex justify-content items-center" style="border-radius:15px 0 0 15px;"><?php _e('<i class="ri-search-line text-xl "></i>'); ?></button>
                <input type="text" id="s" name="s" class="p-1 text bg-white night:bg-white px-4 w-full h-full border" style="border-radius:0 15px 15px 0;" placeholder="<?php _e('输入关键字搜索'); ?>" />
            </div>
        </form>
    </section>
    <nav id="nav-menu" class="mt-8 flex flex-col gap-2 " style="padding-bottom:0.75rem;">
        <div class="flex gap-2 p-1 overflow">
            <a style="padding: 0 0.5rem;" class="no-wrap text-base relative z-1 night:text-gray-100 <?php if($this->is('index')): ?> font-bold active <?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <a style="padding: 0 0.5rem;" class="no-wrap text-base relative z-1 night:text-gray-100 <?php if($this->is('page', $pages->slug)): ?> font-bold active <?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
        </div>
        <span class="relative" style="display:inline;"></span>
    </nav>

        <!--二-->
        <section class="mt-8 p-4 before:background relative">
            <div class="my-5 container-lg mr-auto ml-auto">
                <?php
                define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
if ($this->user->hasLogin()){
    $GLOBALS['isLogin'] = true;
}else{
    $GLOBALS['isLogin'] = false;
}
function threadedComments($comments, $options)
{
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass = 'comment-by-author';
        }
    }
    $db = Typecho_Db::get();

    $enable_comment = $options->class->fields->enable_comment?true:false;
    if (empty($options->class->fields->enable_comment)) $enable_comment = true;
    if ($options->class->fields->enable_comment == '0'){
        $enable_comment = false;
    }
?>
    <li id="li-<?php $comments->theId(); ?>" class="list-none p-4 w-full text-sm submit  transition font-medium rounded-lg btn  py-4 px-6 border-1 border-solid my-2 roundedaA">
        
        <div class="relative">
                <div class="flex gap-3 items-center">
                    <img src="<?php _getAvatarByMail($comments->mail) ?>" width="35px" class="rounded-full border-1 border-solid transition comment-img">
                    <div class="author"><?php $comments->author(); ?></div>
                </div>
            <div class="content commentText " style="padding-left: 48px;">
                <?php
                    echo $comments->content;
                ?>
                <div class="time py-1 text-xs text-bbb my-2">
                    <?php $comments->date('Y年m月d日 H点分s秒 A'); ?>
                </div>
            </div>
        </div>

            <div class="list py-2 ">
            <?php
                $parsedown = new Parsedown();
                
                if ($comments->children) {
                    echo '<div class="list py-2 commentText">';
                    $arr = $comments->children;
                    foreach ($arr as &$val) {
                        $markdownText = $val['text']; // 假设 $val['text'] 包含 Markdown 文本
                        $htmlText = $parsedown->text($markdownText); // 将 Markdown 文本转换为 HTML
                        echo '<div class="item text-xs" id="comment-' . $val['coid'] . '">';
                        echo '<span class="name"style="float:left;">' . $val['author'] . '：‌</span>';
                        echo $htmlText; // 输出转换后的 HTML
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>

        <?php if ($enable_comment) : ?>
        <!--回复框-->
            <form class="reply dynamic-reply" action="<?php _e($options->commentUrl); ?>" method="post" >
                <div class="element">
                    <input type="hidden" name="parent" value="<?php $comments->coid(); ?>">
                    <div class="grid gap-3 Comment_input" style="display:none;">
                        <div class="w-full relative">
                            <i class="ri-user-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                            <input style="border-radius:255px 25px 225px 35px/55px 225px 25px 255px" class="transition w-full rounded text border-1 border-solid p-2" autocomplete="off" placeholder="昵称（必填）" type="text" name="author" value="<?php $options->class->remember('author'); ?>">
                        </div>
                        
                        <div class="w-full relative">
                            <i class="ri-mail-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                            <input style="border-radius:255px 45px 225px 25px/35px 225px 45px 255px" class="transition w-full rounded text border-1 border-solid p-2 " autocomplete="off" placeholder="邮箱（必填）" type="text" name="mail" value="<?php $options->class->remember('mail'); ?>">
                        </div>
                        
                        <div class="w-full relative">
                            <i class="ri-links-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                            <input style="border-radius:255px 25px 225px 45px/35px 225px 15px 255px" class="transition w-full rounded text border-1 border-solid p-2" autocomplete="off" placeholder="网址（选填）" type="text" name="url" value="<?php $options->class->remember('url'); ?>">
                        </div>
                        
                        <input type="hidden" name="_" value="<?php Typecho_Widget::widget('Widget_Security')->to($security);
                        echo $security->getToken($comments->request->getRequestUrl()); ?>">
                    </div>
                    <div class="w-full relative">
                        <i class="ri-layout-horizontal-fill absolute" style="right:5px;top:15px;opacity:.1;"></i>
                        <textarea emoji="😺😸😹😻😼😽🙀😿😾🐵🙈🙉🙊💖💔💯💢👌✌️👍💪🤝🙏🧧🧨🎉👣😄😁😆🤣😂🙂🙃😍😘😋🤪🤭🤫🤔🤨😑😶😏🤕🤧😵🥳😎😕😟😯😳🥺😥😭😱😖😣😫🥱😡"style="margin-top: 0.5rem;max-height:102px;border-radius:255px 10px 225px 25px / 15px 225px 25px 255px;" rows="8" cols="50" name="text" name="text" id="Comment_Textarea-<?php $comments->coid() ?>" class="text-xs rounded w-full Comment_Textarea-<?php $comments->coid() ?> border-1 border-solid transition p-2 Comment_style" onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};" placeholder="请输入评论内容..."></textarea>
                    </div>
                    <div class="Comment_info" style="display:none;">
                        <div class="shadow-lg my-2 border-1 border-solid rounded comment_emoji flex gap-3 relative transition " style="grid-area:emoji;align-self:center;font-size: 1.5em;height:1.75em;line-height:1;border-radius: 255px 35px 225px 25px/25px 225px 25px 255px;">
                            
                            <div class="flex items-center  emoji-btn border rounded-full p-2 text-lg transition">🤚</div>
                            
                            <div class="bottom-0 absolute grid comment_emoji_block gap-3" style=""><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😺')">😺</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😸')">😸</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😹')">😹</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😻')">😻</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😼')">😼</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😽')">😽</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙀')">🙀</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😿')">😿</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😾')">😾</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🐵')">🐵</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙈')">🙈</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙉')">🙉</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙊')">🙊</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '💖')">💖</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '💔')">💔</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '💯')">💯</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '💢')">💢</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '👌')">👌</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '✌️')">✌️</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '👍')">👍</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '💪')">💪</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤝')">🤝</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙏')">🙏</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🧧')">🧧</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🧨')">🧨</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🎉')">🎉</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '👣')">👣</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😄')">😄</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😁')">😁</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😆')">😆</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤣')">🤣</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😂')">😂</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙂')">🙂</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🙃')">🙃</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😍')">😍</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😘')">😘</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😋')">😋</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤪')">🤪</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤭')">🤭</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤫')">🤫</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤔')">🤔</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤨')">🤨</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😑')">😑</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😶')">😶</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😏')">😏</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤕')">🤕</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🤧')">🤧</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😵')">😵</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🥳')">🥳</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😎')">😎</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😕')">😕</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😟')">😟</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😯')">😯</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😳')">😳</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🥺')">🥺</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😥')">😥</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😭')">😭</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😱')">😱</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😖')">😖</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😣')">😣</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😫')">😫</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '🥱')">🥱</span><span onclick="$('textarea.Comment_Textarea-<?php $comments->coid() ?>').val($('textarea.Comment_Textarea-<?php $comments->coid() ?>').val() + '😡')">😡</span>
                            </div>
                            
                        </div>
                            <div class="flex gap-3 my-2">
                                <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('Comment_Textarea-<?php $comments->coid() ?>').value+='[超链接名字](超链接地址)'"><i class="ri-link-unlink text-gray-500"></i></div>
                            <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('Comment_Textarea-<?php $comments->coid() ?>').value+='![图片描述](图片地址)'"><i class="ri-gallery-fill text-gray-500"></i>️</div>
                            <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('Comment_Textarea-<?php $comments->coid() ?>').value += '```代码类型\n代码内容\n```'"><i class="ri-code-s-slash-line text-gray-500"></i></div>
                            <button type="submit" class="w-full text-sm submit p-2  transition font-medium rounded-lg btn py-4 px-6 border-1 border-solid transition roundedaA"><?php _e('提交'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </li>
<?php } ?>

<?php $this->comments()->to($comments); ?>
<!--博主发言框-->
<div class="j-dynamic">
    <input type="hidden" class="j-comment-url" value="<?php $this->commentUrl() ?>">
    <?php if ($this->user->hasLogin()) : ?>
        <div class="respond" id="comments">
            <form method="post" id="dynamic-form" action="<?php $this->commentUrl() ?>">
                <div class="w-full relative">
                    <i class="ri-layout-horizontal-fill absolute" style="right:5px;top:15px;opacity:.1;"></i>
                    <textarea emoji="😺😸😹😻😼😽🙀😿😾🐵🙈🙉🙊💖💔💯💢👌✌️👍💪🤝🙏🧧🧨🎉👣😄😁😆🤣😂🙂🙃😍😘😋🤪🤭🤫🤔🤨😑😶😏🤕🤧😵🥳😎😕😟😯😳🥺😥😭😱😖😣😫🥱😡"style="margin-top: 0.5rem;max-height:120px;border-radius:255px 10px 225px 25px / 15px 225px 25px 255px;" rows="8" cols="50" name="text" id="textarea" tyle="border-radius:255px 10px 225px 25px / 15px 225px 25px 255px;" class="shadow-lg text-xs rounded w-full Comment_Textarea-bozhu border-1 border-solid transition p-2 textarea" aria-required="true" onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};" required><?php $this->remember('text'); ?></textarea>
                </div>
                <input type="hidden" value="<?php $this->user->screenName(); ?>" name="author" />
                <input type="hidden" value="<?php $this->user->mail(); ?>" name="mail" />
                <input type="hidden" value="<?php $this->options->siteUrl(); ?>" name="url" />
                <input type="hidden" name="_" value="<?php Typecho_Widget::widget('Widget_Security')->to($security);
                echo $security->getToken($this->request->getRequestUrl()); ?>">
                <div class="shadow-lg my-2 border-1 border-solid rounded comment_emoji flex gap-3 relative transition " style="grid-area:emoji;align-self:center;font-size: 1.5em;height:1.75em;line-height:1;border-radius: 255px 35px 225px 25px/25px 225px 25px 255px;">
                    <div class="flex items-center  emoji-btn border rounded-full p-2 text-lg transition">🤚</div>
                    <div class="bottom-0 absolute grid comment_emoji_block gap-3" style=""><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😺')">😺</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😸')">😸</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😹')">😹</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😻')">😻</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😼')">😼</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😽')">😽</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙀')">🙀</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😿')">😿</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😾')">😾</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🐵')">🐵</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙈')">🙈</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙉')">🙉</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙊')">🙊</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '💖')">💖</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '💔')">💔</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '💯')">💯</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '💢')">💢</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '👌')">👌</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '✌️')">✌️</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '👍')">👍</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '💪')">💪</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤝')">🤝</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙏')">🙏</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🧧')">🧧</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🧨')">🧨</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🎉')">🎉</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '👣')">👣</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😄')">😄</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😁')">😁</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😆')">😆</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤣')">🤣</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😂')">😂</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙂')">🙂</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🙃')">🙃</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😍')">😍</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😘')">😘</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😋')">😋</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤪')">🤪</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤭')">🤭</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤫')">🤫</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤔')">🤔</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤨')">🤨</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😑')">😑</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😶')">😶</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😏')">😏</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤕')">🤕</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🤧')">🤧</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😵')">😵</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🥳')">🥳</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😎')">😎</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😕')">😕</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😟')">😟</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😯')">😯</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😳')">😳</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🥺')">🥺</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😥')">😥</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😭')">😭</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😱')">😱</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😖')">😖</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😣')">😣</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😫')">😫</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '🥱')">🥱</span><span onclick="$('textarea.Comment_Textarea-bozhu').val($('textarea.Comment_Textarea-bozhu').val() + '😡')">😡</span>
                    </div>
                    
                    
                </div>
                
                
                <div class="flex gap-3 my-2">
                    <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('textarea').value+='[超链接名字](超链接地址)'"><i class="ri-link-unlink "></i></div>
                    <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('textarea').value+='![图片描述](图片地址)'"><i class="ri-gallery-fill "></i>️</div>
                    <div class="flex items-center text-sm submit p-2  transition font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('textarea').value += '```代码类型\n代码内容\n```'">
                    <i class="ri-code-s-slash-line "></i></div>
                    <button type="submit" class="w-full text-sm submit p-2  transition font-medium rounded-lg btn py-4 px-6 border-1 border-solid transition roundedaA"><?php _e('提交'); ?></button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <?php $comments->listComments(['commentUrl'=>$this->commentUrl,'class'=>$this]); ?>

    <?php $comments->pageNav(
        '<button style="border-color:transparent;" class="bg-transparent">上页</button>',
        '<button style="border-color:transparent;" class="bg-transparent">下页</button>',
        1,
        '...',
        array(
            'wrapTag' => 'ul',
            'wrapClass' => 'j-pagination gap-3',
            'itemTag' => 'li',
            'textTag' => 'a',
            'currentClass' => 'active',
            'prevClass' => 'prev',
            'nextClass' => 'next'
        )
    ); ?>
</div>
                
                
            </div>
        </section>
        
</main>
    <?php $this->need('footer.php'); ?>
    
<script>
    function changeURLArg(url,arg,arg_val){
        let pattern=arg+'=([^&]*)';
        let replaceText=arg+'='+arg_val;
        if(url.match(pattern)){
            let tmp='/('+ arg+'=)([^&]*)/gi';
            tmp=url.replace(eval(tmp),replaceText);
            return tmp;
        }else{
            if(url.match('[\?]')){
                return url+'&'+replaceText;
            }else{
                return url+'?'+replaceText;
            }
        }
    }
        /* 初始化微语发布 */
    function init_dynamic_verify() {
    // 保存this的引用，‌以便在回调函数中使用
    let _this = this;

    // 移除#dynamic-form上的submit事件处理器，‌然后添加一个新的
    $('#dynamic-form').off('submit').on('submit', function (e) {
        // 阻止表单的默认提交行为
        e.preventDefault();

        // 获取表单中的按钮
        let btn = $("#dynamic-form .form-foot button");

        // 获取表单输入内容并去除首尾空格
        let inputContent = $('#dynamic-form-text').val().trim();

        // 如果输入内容为空，‌则弹出提示并返回
        if (inputContent === '') {
            alert('请输入发表内容');
            return;
        }

        // 如果表单已经标记为禁用状态，‌则直接返回
        if ($(this).attr('data-disabled')) {
            return;
        }

        // 标记表单为禁用状态，‌防止重复提交
        $(this).attr('data-disabled', true);

        // 设置按钮文本为“发表中...”
        btn.text("发表中...");

        // 这里可以添加AJAX请求或其他逻辑来处理表单提交
        // 例如：‌$.ajax({...})
    });
}



</script>

