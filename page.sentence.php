<?php
/**
 * 
 * 句子 ✍️️
 * 
 * @package custom
 * 
 * @author  林厌
 * 
 * @time 2024.8.21
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
                <?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
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
                        <li itemscope itemtype="http://schema.org/UserComments" class="list-none my-2 comment-body transition <?php
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
                            <div class="comment-col relative transition rounded  my-4 <?php echo $randomClass;?> " id="<?php $comments->theId(); ?>">
                                <div class="comment_content border-1 border-solid">
                                    <div class="comment_size p-4">
                                            <div class="text-bbb comment-author " itemprop="creator" itemscope itemtype="http://schema.org/Person">
                                                <div class="flex items-center gap-3 py-4">
                                                    <!--名字-->
                                                    <b class="fn " itemprop="name"><?php $comments->author(); ?></b>
                                                    <!--@-->
                                                    <?php $parentMail = get_comment_at($comments->coid)?><?php echo $parentMail;?>
                                                    
                                                    
                                                    <?php if ('waiting' == $comments->status) { ?>
                                                        <em class="comment-awaiting-moderation text-xs px-1 text-bbb">您的评论正等待审核!</em>
                                                    <?php } ?>
                                                    
                                                </div>
                                                
                                                <div class="comment-content px-1 text-sm pb-3 text-gray" itemprop="commentText" >
                                                <?php
                                                    
                                                    echo $comments->content;
                                                ?>
                                                </div>
                                                
                                                <div class="comment-info flex gap-3 " style="justify-content:flex-end;">
                            <time class="text-xs px-1 text-bbb commentTime transition-out" itemprop="commentTime" datetime="<?php $comments->date('c'); ?>">
                                <?php echo human_time_diff($comments->created); ?>
                            </time>
                        </div>
                        
                                            </div>
                                        </li>
                                        <?php
                                    }
                                ?>
                
                <div id="comments">
                    <?php $this->comments()->to($comments); ?>
                
                    <?php if ($this->allow('comment')): ?>
                        <div id="<?php $this->respondId(); ?>" class="respond my-2">
                            
                            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" class="pt-7 links">
                                <?php if ($this->user->hasLogin()): ?>
                                    <p><?php _e('登录身份: '); ?><a
                                            href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a
                                            href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                                    </p>
                                
                                <div class="w-full relative">
                                    <i class="ri-layout-horizontal-fill absolute" style="right:5px;top:15px;opacity:.1;"></i>
                                    <textarea style="max-height:100px;border-radius:255px 10px 225px 25px / 15px 225px 25px 255px;" rows="8" cols="50" name="text" id="textarea" class="rounded w-full my-2 text-bbb bg-tertiaryB border-1 border-solid transition border-primary hover:border-secondary border-primary p-2 textarea"
                                              required><?php $this->remember('text'); ?></textarea>
                                </div>
                                <button type="submit" class="rounded text-sm submit text-bbb p-2 hover:border-secondary hover:color-gray transition min-w-40 font-medium rounded-lg btn text-secondary bg-tertiaryB py-4 px-6 border-1 border-solid border-primary transition roundedaA"><?php _e('提交'); ?></button>
                            </form>
                            <?php else: ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <h3><?php _e('评论已关闭'); ?></h3>
                    <?php endif; ?>
                    
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
        </section>
</main>
    
    <?php $this->need('footer.php'); ?>
    
</body>
    
</html>
