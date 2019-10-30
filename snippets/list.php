
<div class="page-core">
  <ul class="list">
    <?php foreach($section->children()->visible() as $listItem): ?>
    <?php snippet('list-item', array('listItem' => $listItem)); ?>
    <?php endforeach; ?>
    <!-- list item info box-->
    <?php snippet('list-item-info-box'); ?>
  </ul>
</div>