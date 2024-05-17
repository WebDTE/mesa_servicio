<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>
<div class="row">
<div class="col-12 col-sm-8">
<div class="">
  <h1 class="d-none"><?php echo __('Frequently Asked Question');?></h1>
  <div id="breadcrumbs" style="padding-top:2px;">
      <a href="index.php"><?php echo __('All Categories');?></a>
      &raquo; <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php
      echo $category->getFullName(); ?></a>
  </div>
</div>

<div class="faq-content">
<h1 class="h2">
<?php echo $faq->getLocalQuestion() ?>
</h1>
<div class="faded"><?php echo sprintf(__('Last Updated %s'),
    Format::relativeTime(Misc::db2gmtime($faq->getUpdateDate()))); ?></div>
<br/>
<div class="thread-body bleed">
<?php echo $faq->getLocalAnswerWithImages(); ?>
</div>
</div>
</div>

<div class="col-12 col-sm-4 pull-right">
<div class="sidebar">
<div class="searchbar">
    <form method="get" action="faq.php">
    <input type="hidden" name="a" value="search"/>
    <input type="text" name="q" class="search" placeholder="<?php
        echo __('Search our knowledge base'); ?>"/>
    <input type="submit" style="display:none" value="search"/>
    </form>
</div>
<div class="bg-light rounded p-3 border"><?php
    if ($attachments = $faq->getLocalAttachments()->all()) { ?>
<section>
    <strong><?php echo __('Attachments');?>:</strong>
<?php foreach ($attachments as $att) { ?>
    <div>
    <a href="<?php echo $att->file->getDownloadUrl(['id' => $att->getId()]);
    ?>" class="no-pjax">
        <i class="icon-file"></i>
        <?php echo Format::htmlchars($att->getFilename()); ?>
    </a>
    </div>
<?php } ?>
</section>
<?php }
if ($faq->getHelpTopics()->count()) { ?>
<section>
    <strong><?php echo __('Help Topics'); ?></strong>
<?php foreach ($faq->getHelpTopics() as $T) { ?>
    <div><?php echo $T->topic->getFullName(); ?></div>
<?php } ?>
</section>
<?php }
?></div>
</div>
</div>

</div>
