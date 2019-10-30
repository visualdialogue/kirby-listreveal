
<?php $team_memberData = $site->teamMemberData($team_member); ?>
<?php $team_memberDataDecoded = json_decode($team_memberData, true); ?>
<?php $team_memberBio = $team_memberDataDecoded['bio']; ?>
<?php $clickable = ('' != $team_memberBio ? true : false); ?>
<?php $image = $team_member->image($team_member->profile()); ?>
<li data-button="<?= str::slug($team_member->title()) ?>-desktop" data-area="team-member-sub-section-desktop" data-closex="team-member-sub-section-desktop-x" data-team-member-data="<?= htmlspecialchars($team_memberData) ?>" class="team-member revealer <?= e($clickable, 'clickable') ?> <?= e(!$image, 'no-profile-image') ?>">
  <?php if($image): ?>
  <picture class="profile-image">
    <source srcset="<?= $image->focusCrop(200,200,['quality' => 80])->url() ?> 1x, <?= $image->focusCrop(399,399,['quality' => 80])->url() ?> 2x" media="(min-width: 768px)"/><img srcset="<?= $image->focusCrop(399,399,['quality' => 80])->url() ?>" alt="<?= $team_member->title() ?>"/>
  </picture>
  <?php else: ?><img src="https://via.placeholder.com/170" class="team-member-image"/>
  <?php endif; ?>
  <div class="team-member-details">
    <div class="team-member-name">
      <?php echo $team_member->title(); ?></div>
    <?php if('' != $team_member->position()): ?>
    <div class="team-member-position">
      <?php echo $team_member->position(); ?></div>
    <?php else: ?>
    <div class="team-member-position">Title</div>
    <?php endif; ?>
  </div>
</li>