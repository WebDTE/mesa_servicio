<?php
if(!defined('OSTCLIENTINC') || !$category || !$category->isPublic()) die('Access Denied');
?>
<div class="row">
<div class="col-12 col-md-8">
    <h1 class="h3"><?php echo $category->getFullName(); ?></h1>
<p>
<?php echo Format::safe_html($category->getLocalDescriptionWithImages()); ?>
</p>
<?php

if (($subs=$category->getSubCategories(array('public' => true)))) {
    echo '<div class="">';
    foreach ($subs as $c) {
        echo sprintf('<div class="bg-light border rounded p-3 mb-3"><i class="fas fa-book text-prepa-coral"></i>
                <a href="faq.php?cid=%d" class="text-prepa-verde">%s (%d)</a></div>',
                $c->getId(),
                $c->getLocalName(),
                $c->getNumFAQs()
                );
    }
    echo '</div>';
} ?>
<hr>
<?php
$faqs = FAQ::objects()
    ->filter(array('category'=>$category))
    ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
    ->annotate(array('has_attachments' => SqlAggregate::COUNT(SqlCase::N()
        ->when(array('attachments__inline'=>0), 1)
        ->otherwise(null)
    )))
    ->order_by('-ispublished', 'question');

if ($faqs->exists(true)) {
    echo '
         <h2>'.__('Frequently Asked Questions').'</h2>
         <div class="d-flex flex-column" id="faq">';
foreach ($faqs as $F) {
        //Borro el icono
        $attachments=$F->has_attachments?'<i class="fas fa-question-circle text-prepa-morado"></i>':'';
        echo sprintf('
            <div class="d-block bg-light rounded p-2 mb-2"><a href="faq.php?id=%d" class="text-prepa-verde"><i class="fas fa-question-circle text-prepa-coral"></i> %s &nbsp;%s</a></div>',
            $F->getId(),Format::htmlchars($F->question), '');
    }
    echo '</div>';
} elseif (!$category->children) {
    echo '<strong>'.__('This category does not have any FAQs.').' <a href="index.php">'.__('Back To Index').'</a></strong>';
}
?>
</div>

<div class="col-12 col-md-4">
    <div class="sidebar">
    <div class="searchbar mb-3">
        <form method="get" action="faq.php">
        <input type="hidden" name="a" value="search"/>
        <input type="text" name="q" class="form-control" placeholder="<?php
            echo __('Search our knowledge base'); ?>"/>
        <input type="submit" style="display:none" value="search"/>
        </form>
    </div>
    <div class="bg-light rounded p-3 border">
        <section>
            <div class="header"><?php echo __('Help Topics'); ?></div>
<?php
foreach (Topic::objects()
    ->filter(array('faqs__faq__category__category_id'=>$category->getId()))
    ->distinct('topic_id')
    as $t) { ?>
        <a href="?topicId=<?php echo urlencode($t->getId()); ?>"
            ><?php echo $t->getFullName(); ?></a>
<?php } ?>
        </section>
    </div>
    </div>
</div>
</div>
