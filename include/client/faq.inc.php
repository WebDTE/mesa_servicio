<?php
if (!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category = $faq->getCategory();

?>
<div class="row">
    <div class="col-12 col-md-8">

        <h1><?php echo __('Frequently Asked Question'); ?></h1>
        <div id="breadcrumbs" style="padding-top:2px;">
            <a href="index.php"><?php echo __('All Categories'); ?></a>
            &raquo; <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php
                                                                            echo $category->getFullName(); ?></a>
        </div>

        <div class="faq-content">
            <h2>
                <?php echo $faq->getLocalQuestion() ?>
            </h2>
            <div class="faded"><?php echo sprintf(
                                    __('Last Updated %s'),
                                    Format::relativeTime(Misc::db2gmtime($faq->getUpdateDate()))
                                ); ?></div>
            <br />
            <div class="thread-body bleed">
                <?php echo $faq->getLocalAnswerWithImages(); ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="sidebar">
            <div class="searchbar mb-3">
                <form method="get" action="faq.php" class="for-tabla">
                    <input type="hidden" name="a" value="search" />
                    <input type="text" name="q" class="search" placeholder="<?php
                                                                            echo __('Search our knowledge base'); ?>" />
                    <input type="submit" style="display:none" value="search" />
                </form>
            </div>
            <div class="content for-tabla text-center"><?php
                                                        if ($attachments = $faq->getLocalAttachments()->all()) { ?>
                    <section>
                        <strong><?php echo __('Attachments'); ?>:</strong>
                        <?php foreach ($attachments as $att) { ?>
                            <div class="catt text-center">
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
                            <div class="catt text-center"><?php echo $T->topic->getFullName(); ?></div>
                        <?php } ?>
                    </section>
                <?php }
                ?>
            </div>
        </div>
    </div>

</div>