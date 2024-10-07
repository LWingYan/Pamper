<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
//如果你想使用其他评论头像插件，请注释下面这行代码！
// define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
?>
<?php function threadedComments($comments, $options){
 $commentClass = '';
        if ($comments->authorId) {
            if ($comments->authorId == $comments->ownerId) {
                $commentClass .= ' comment-by-author';
            } else {
                $commentClass .= ' comment-by-user';
            }
        }
        ?>
        <li itemscope itemtype="http://schema.org/UserComments" class="list-none mt-8 comment-body transition <?php
        if ($comments->levels > 0) {
            echo ' comment-child';
            $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
        } else {
            echo ' comment-parent';
        }
        $comments->alt(' comment-odd', ' comment-even');
        echo $commentClass;
        ?>">
            <?php
                // 背景颜色数组
                $card_bg = [];
                $bg_color = [
                    'bg1',
                    'bg2',
                    'bg3',
                    'bg4',
                    'bg5',
                ];
                // 随机选择背景颜色和对齐方式
                $randomIndex = array_rand($bg_color);
                $randomClass = $bg_color[$randomIndex];
               ?>
               
            <div class="comment-col relative transition rounded  my-2 <?php echo $randomClass;?>" id="<?php $comments->theId(); ?>">
                <article class="flex gap-3 w-full">
                    <img src="<?php _getAvatarByMail($comments->mail) ?>" class="roundedaA border-2 border-solid" width="45" height="45">
                    <div class="w-full">
                        <div class="comment-author w-full <?php
        					if ($comments->authorId) {
        						if ($comments->authorId == $comments->ownerId) {
        							_e('comment-admin');
        						}
        					}
        					?> " itemprop="creator" itemscope itemtype="http://schema.org/Person">
                            <!-- 评论者 -->
                            <b class="fn text-gray-100 night:text-gray-500" itemprop="name"><?php $comments->author(); ?></b>
                            <!--@-->
                            <?php $parentMail = get_comment_at($comments->coid)?><?php echo $parentMail;?>
                            <?php if ('waiting' == $comments->status) { ?>
                                <em class="comment-awaiting-moderation text-xs px-1" style="color:var(--c-red-500);">您的评论正等待审核!</em>
                            <?php } ?>
                            <div class="p-2 w-full roundedaA border-1 border-solid comment-content px-1 text-sm pb-3 text-gray commentText border-black text-gray-100 night:text-gray-300" itemprop="commentText">
                            <?php
                                
                                echo $comments->content;
                            ?>
                            </div>
                            <div class="my-2 text-gray-500">
                                <time class="text-xs commentTime " itemprop="commentTime" datetime="<?php $comments->date('c'); ?>">
                                    <?php echo human_time_diff($comments->created); ?>
                                </time>
                                <span> · </span>
                                <span class="px-1 comment-reply text-xs cp-<?php $comments->theId(); ?> text-muted comment-reply-link"><?php $comments->reply('回复'); ?></span><span id="cancel-comment-reply" class="px-1 text-xs cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link" style="display:none" ><?php $comments->cancelReply('取消'); ?></span>
                            </div>
                        </div>
                    </div>
                </article>
                
            <?php if ($comments->children) { ?>
                <div class="comment-children" style="padding-left:50px;" itemprop="discusses">
                    <?php $comments->threadedComments(); ?>
                </div>
            <?php } ?>
        </li>
        <?php
    }
?>

<div id="comments">
    <?php $this->comments()->to($comments); ?>

    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond mt-8 comment-respond">
            
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" class="comment-form pt-7 links">
                <?php if ($this->user->hasLogin()): ?>
                    <p><?php _e('登录身份: '); ?><a
                            href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a
                            href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                    </p>
                <?php else: ?>
                <div class="flex flex-col gap-3">
                    <div class="w-full relative">
                        <i class="ri-user-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                        <input style="border-radius:255px 25px 225px 35px/55px 225px 25px 255px" type="text" name="author" id="author" class="shadow-lg transition w-full rounded text border-1 border-solid p-2"
                               value="<?php $this->remember('author'); ?>" required/>
                    </div>
                    
                    <div class="w-full relative">
                        <i class="ri-mail-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                        <input style="border-radius:255px 45px 225px 25px/35px 225px 45px 255px" type="email" name="mail" id="mail" class="shadow-lg transition w-full rounded text border-1 border-solid p-2"
                               value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                    </div>
                    
                    <div class="w-full relative">
                        <i class="ri-links-line absolute" style="right:5px;top:8px;opacity:.1;"></i>
                        <input style="border-radius:255px 25px 225px 45px/35px 225px 15px 255px" type="url" name="url" id="url" class="shadow-lg transition w-full rounded text border-1 border-solid p-2" placeholder="<?php _e('http://'); ?>"
                               value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                    </div>
                </div>
                <?php endif; ?>
                <div class="w-full relative">
                    <i class="ri-layout-horizontal-fill absolute" style="right:5px;top:15px;opacity:.1;"></i>
                    <textarea emoji="😺😸😹😻😼😽🙀😿😾🐵🙈🙉🙊💖💔💯💢👌✌️👍💪🤝🙏🧧🧨🎉👣😄😁😆🤣😂🙂🙃😍😘😋🤪🤭🤫🤔🤨😑😶😏🤕🤧😵🥳😎😕😟😯😳🥺😥😭😱😖😣😫🥱😡"style="margin-top: .5rem;max-height:100px;border-radius:255px 10px 225px 25px / 15px 225px 25px 255px;" rows="8" cols="50" name="text" id="textarea" class="rounded w-full Comment_Textarea shadow-lg border-1 border-solid p-2 textarea" aria-required="true" onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};" required><?php $this->remember('text'); ?></textarea>
                </div>
                
                <div class="shadow-lg my-2 border-1 border-solid rounded comment_emoji flex gap-3 relative transition " style="grid-area:emoji;align-self:center;font-size: 1.5em;height:1.75em;line-height:1;border-radius: 255px 35px 225px 25px/25px 225px 25px 255px;">
                    <div class="flex items-center text-white emoji-btn border rounded-full p-2 text-lg transition-out">🤚</div>
                    
                    <div class="bottom absolute grid comment_emoji_block gap-3" style=""><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😺')">😺</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😸')">😸</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😹')">😹</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😻')">😻</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😼')">😼</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😽')">😽</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙀')">🙀</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😿')">😿</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😾')">😾</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🐵')">🐵</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙈')">🙈</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙉')">🙉</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙊')">🙊</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💖')">💖</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💔')">💔</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💯')">💯</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💢')">💢</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👌')">👌</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '✌️')">✌️</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👍')">👍</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💪')">💪</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤝')">🤝</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙏')">🙏</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🧧')">🧧</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🧨')">🧨</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🎉')">🎉</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👣')">👣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😄')">😄</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😁')">😁</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😆')">😆</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤣')">🤣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😂')">😂</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙂')">🙂</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙃')">🙃</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😍')">😍</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😘')">😘</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😋')">😋</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤪')">🤪</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤭')">🤭</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤫')">🤫</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤔')">🤔</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤨')">🤨</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😑')">😑</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😶')">😶</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😏')">😏</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤕')">🤕</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤧')">🤧</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😵')">😵</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥳')">🥳</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😎')">😎</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😕')">😕</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😟')">😟</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😯')">😯</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😳')">😳</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥺')">🥺</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😥')">😥</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😭')">😭</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😱')">😱</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😖')">😖</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😣')">😣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😫')">😫</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥱')">🥱</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😡')">😡</span>
                    </div>
                    
                </div>
                
                
                <div class="flex gap-3 my-2">
                    <div class="shadow-lg flex items-center text-sm submit p-2 font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('textarea').value+='[超链接名字](超链接地址)'"><i class="ri-links-line text-gray-500"></i></div>
                    <div class="shadow-lg flex items-center text-sm submit p-2 font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA" onclick="document.getElementById('textarea').value+='![图片描述](图片地址)'"><i class="ri-gallery-fill text-gray-500"></i>️</div>
                    <button type="submit" id="submitComment" class="shadow-lg w-full text-sm submit text-bbb p-2 font-medium rounded-lg btn py-4 px-6 border-1 border-solid roundedaA"><?php _e('提交'); ?></button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="mt-8 comments-off flex flex-col gap-3 w-full" >
            <div class="flex flex-col gap-3 w-full" style="align-items:flex-start;">
                <div class="flex flex-col gap-3 w-full" style="align-items:flex-end;">
                    <?php
                        // 背景颜色数组
                        $card_bg = [];
                        $bg_color = ['bg1', 'bg2', 'bg3', 'bg4', 'bg5'];
                        // 随机选择背景颜色和对齐方式
                        $randomIndex = array_rand($bg_color);
                        $randomClass = $bg_color[$randomIndex];
                   ?>
                    <div class="p-1 <?php echo $randomClass;?> " style="width:fit-content;">
                        <?php _e('目前已关闭评论'); ?>
                    </div>
                    
                    <?php
                        // 重新随机选择背景颜色和对齐方式
                        $randomIndex = array_rand($bg_color);
                        $randomClass = $bg_color[$randomIndex];
                   ?>
                </div>
                
                <div class="p-1 <?php echo $randomClass;?> " style="width:fit-content;">
                    <?php _e('走 我们还不稀罕评论 '); ?>
                </div>
                <?php
                    // 重新随机选择背景颜色和对齐方式
                    $randomIndex = array_rand($bg_color);
                    $randomClass = $bg_color[$randomIndex];
               ?>
                <div class="p-1 <?php echo $randomClass;?> " style="width:fit-content;">
                    <?php _e('哼'); ?>
                </div>
            </div>
            <div class="flex flex-col gap-3 w-full" style="align-items:flex-end;">
                <?php
                    // 重新随机选择背景颜色和对齐方式
                    $randomIndex = array_rand($bg_color);
                    $randomClass = $bg_color[$randomIndex];
               ?>
                <div class="p-1 <?php echo $randomClass;?> " style="width:fit-content;">
                    <?php _e('不要啊'); ?>
                </div>
            </div>
            
        </div>
        
    <?php endif; ?>
    
    <div class="Comments-lists">
    
    <?php if ($comments->have()): ?>
    
    <?php $comments->listComments(); ?>
        <div class="comment-pagegroup flex gap-3 justify-between text-xs">
    <?php
    
    $npattern = '/\<li.*?class=\"next\"><a.*?\shref\=\"(.*?)\"[^>]*>/i';
    $ppattern = '/\<li.*?class=\"prev\"><a.*?\shref\=\"(.*?)\"[^>]*>/i';
    ob_start();
    $comments->pageNav();
    $con = ob_get_clean();
    $n=preg_match_all($npattern, $con, $nextlink);
    $p=preg_match_all($ppattern, $con, $prevlink);
    if($n){
    $nextlink=$nextlink[1][0];
    $nextlink=str_replace("#comments","?type=comments",$nextlink);
    }else{
    $nextlink=false;
    }
    
    if($p){
    $prevlink=$prevlink[1][0];
    $prevlink=str_replace("#comments","?type=comments",$prevlink);
    }else{
    $prevlink=false;
    }
    ?>
    <?php if($prevlink): ?>
        <a href="<?php echo $prevlink; ?>" class="content-page">
            <button class="shadow-lg flex items-center text-sm submit p-2 font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA  ">上页</button>
        </a>
    <?php else: ?>
    <div></div>
    <?php endif; ?>
    <?php if($nextlink): ?>
        <a href="<?php echo $nextlink; ?>" class="content-page">
                <button class="shadow-lg flex items-center text-sm submit p-2 font-medium rounded-lg py-4 px-6 border-1 border-solid transition roundedaA ">下页</button>
        </a>
    <?php endif; ?>
    
        </div>
    <?php endif; ?>
    </div>
</div>
<style>
#cancel-comment-reply-link {
    display: inline !important;
}
</style>
<script>
    function showhidediv(id){var sbtitle=document.getElementById(id);if(sbtitle){if(sbtitle.style.display=='flex'){sbtitle.style.display='none';}else{sbtitle.style.display='flex';}}}
(function(){window.TypechoComment={dom:function(id){return document.getElementById(id)},pom:function(id){return document.getElementsByClassName(id)[0]},iom:function(id,dis){var alist=document.getElementsByClassName(id);if(alist){for(var idx=0;idx<alist.length;idx++){var mya=alist[idx];mya.style.display=dis}}},create:function(tag,attr){var el=document.createElement(tag);for(var key in attr){el.setAttribute(key,attr[key])}return el},reply:function(cid,coid){var comment=this.dom(cid),parent=comment.parentNode,response=this.dom("<?php echo $this->respondId(); ?>"),input=this.dom("comment-parent"),form="form"==response.tagName?response:response.getElementsByTagName("form")[0],textarea=response.getElementsByTagName("textarea")[0];if(null==input){input=this.create("input",{"type":"hidden","name":"parent","id":"comment-parent"});form.appendChild(input)}input.setAttribute("value",coid);if(null==this.dom("comment-form-place-holder")){var holder=this.create("div",{"id":"comment-form-place-holder"});response.parentNode.insertBefore(holder,response)}comment.appendChild(response);this.iom("comment-reply","");this.pom("cp-"+cid).style.display="none";this.iom("cancel-comment-reply","none");this.pom("cl-"+cid).style.display="";if(null!=textarea&&"text"==textarea.name){textarea.focus()}return false},cancelReply:function(){var response=this.dom("<?php echo $this->respondId(); ?>"),holder=this.dom("comment-form-place-holder"),input=this.dom("comment-parent");if(null!=input){input.parentNode.removeChild(input)}if(null==holder){return true}this.iom("comment-reply","");this.iom("cancel-comment-reply","none");holder.parentNode.insertBefore(response,holder);return false}}})();
</script>