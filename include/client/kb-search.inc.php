<div class="row">
<div class="col-12 col-md-8">
    <h1><?php echo __('Frequently Asked Questions');?></h1>
    <div><strong><?php echo __('Search Results'); ?></strong></div>
<?php
    if ($faqs->exists(true)) {
        echo '<div id="faq">'.sprintf(__('%d FAQs matched your search criteria.'),
            $faqs->count())
            .'<ol>';
        foreach ($faqs as $F) {
            echo sprintf(
                '<li><a href="faq.php?id=%d" class="previewfaq">%s</a></li>',
                $F->getId(), $F->getLocalQuestion(), $F->getVisibilityDescription());
        }
        echo '</ol></div>';
    } else {
        echo '<strong class="faded">'.__('The search did not match any FAQs.').'</strong>';
    }
?>
</div>

<div class="col-12 col-md-4">
    <div class="sidebar">
    <div class="searchbar text-center mb-3">
        <form method="get" action="faq.php" class="for-tabla">
        <input type="hidden" name="a" value="search"/>
        <input type="text" name="q" class="form-control" placeholder="<?php
            echo __('Search our knowledge base'); ?>"/>
        <input type="submit" style="display:none" value="search"/>
        </form>
    </div>
    <div class="content for-tabla ">
        <section>
            <div class="catt text-center"><?php echo __('Help Topics'); ?></div>
<?php
foreach (Topic::objects()
    ->annotate(array('faqs_count'=>SqlAggregate::count('faqs')))
    ->filter(array('faqs_count__gt'=>0))
    as $t) { ?>
        <div><a href="?topicId=<?php echo urlencode($t->getId()); ?>"
            >- <?php echo $t->getFullName(); ?></a></div>
<?php } ?>
        </section>
        <section>
            <div class="catt text-center"><?php echo __('Categories'); ?></div>
<?php
foreach (Category::objects()
    ->exclude(Q::any(array('ispublic'=>Category::VISIBILITY_PRIVATE)))
    ->annotate(array('faqs_count'=>SqlAggregate::count('faqs')))
    ->filter(array('faqs_count__gt'=>0))
    as $C) { ?>
        <div><a href="?cid=<?php echo urlencode($C->getId()); ?>"
            >- <?php echo $C->getLocalName(); ?></a></div>
<?php } ?>
        </section>
    </div>
    </div>
</div>
</div>
