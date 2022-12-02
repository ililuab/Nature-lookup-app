<?php get_header();?>
<?php $home_video = get_field('home_video');?>
<div class="p-0 container-fluid">
    <video class="home_video" src="<?= $home_video['url']; ?>"  autoplay loop muted></video>
    <div class="text-center m-0 row overlay ">
        <div class="col-12">
            <?php 
            $title = get_field('top_page_title');
            $description = get_field('top_page_description');
            if($title):
            ?>
            <h1 class="mb-3 titel"><?= $title; ?></h1>
            <?php endif;
            if($description):?>
            <p class="description"><?= $description; ?></p>
            <?php endif; ?>
            <div class="autocomplete-container" id="autocomplete-container"></div>
        </div>
    </div>
    <?php $logo = get_field('logo'); ?>
    <a href="/"><?= wp_get_attachment_image($logo['ID'], 'logo', false, ['class'=>'logo']); ?></a>
</div>
<?php get_footer(); ?>