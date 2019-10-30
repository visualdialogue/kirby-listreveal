
<?php $memberData = $site->memberData($member); ?>
<?php $memberDataDecoded = json_decode($memberData, true); ?>
<?php $memberDescription = $memberDataDecoded['description']; ?>
<?php $clickable = ('' != $memberDescription ? true : false); ?>
<?php $image = $member->image(); ?>
<li data-button="<?= str::slug($member->title()) ?>-desktop" data-area="team-member-sub-section-desktop" data-closex="team-member-sub-section-desktop-x" data-list-item-data="<?= htmlspecialchars($memberData) ?>" class="member reveal-item <?= e($clickable, 'clickable') ?> <?= e(!$image, 'no-profile-image') ?>">
  <?php if($image): ?>
  <div class="member-picture-wrapper">
    <picture class="member-picture">
      <source srcset="<?= $image->focusCrop(260, 195, ['quality' => 80])->url() ?>, <?= $image->focusCrop(520, 390, ['quality' => 80])->url() ?> 2x" media="(min-width: 769px)"/><img src="<?= $image->focusCrop(260, 195,['quality' => 80])->url() ?>" alt="<?= $member->title() ?>"/>
    </picture>
  </div>
  <?php else: ?>
  <div class="member-picture-wrapper">
    <picture class="member-picture"><img srcset="https://via.placeholder.com/260x195"/></picture>
  </div>
  <?php endif; ?>
  <div class="member-title">
    <?php echo $member->title(); ?></div>
</li>