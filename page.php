<?php
/**
 * 宠溺 
 *
 * @package pamper
 * @author 林孽
 * @version 1.2
 * @link //ouyu.me
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
    <section class="mt-8 post_article ">
                <article class="my-2 card transition w-full rotate--3deg " style="">
                    <div class="shadow-lg roundedaB  p-4 border-solid border-2 border-black rounded-2xl relative bg-white night:bg-white">
                        <span class="card-pin simple1 bg-gray-900 absolute z-1"></span>
                        <span class="card-pin simple2 bg-gray-900 absolute z-1"></span>
                        <span class="card-pin simple3 bg-gray-900 absolute z-1"></span>
                        <span class="card-pin simple4 bg-gray-900 absolute z-1"></span>
                        <span class="card-pin simple5 bg-gray-900 absolute z-1"></span>
                        <span class="card-pin simple6 bg-gray-900 absolute z-1"></span>
                        <div class="" style="padding-top:40px;padding-bottom:20px;">
                            <div class="border-bottom-style" style="text-align:center;padding-bottom:5px;">
                                <h3 style="padding-bottom:8px;"><?php $this->title() ?></h3>
                            </div>
                            <div class=" post-content">
                                <?php article_changetext($this, $this->user->hasLogin()) ?>
                            </div>
                        </div>
                    </div>
                </article>
        
    </section>
    <section class="mt-8 ">
        <?php $this->need('comments.php'); ?>
    </section>
</main>

<?php $this->need('footer.php'); ?>




