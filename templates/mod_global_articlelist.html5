<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline || count($this->tags_activetags)): ?>
<<?php echo $this->hl; ?>><?php echo (strlen($this->headline)) ? $this->headline : join($this->tags_activetags, "+"); ?> <?php if (count($this->articles)): ?>(<?php echo count($this->articles); ?>)<?php endif; ?></<?php echo $this->hl; ?>>
<?php endif; ?>
<?php if (count($this->articles)): ?>
<ul>
<?php foreach ($this->articles as $article): ?>
  <li>
		<?php echo $article['content']; ?>
<?php if ($this->showTags): ?>
		<?php echo $article['tags']; ?>
<?php endif; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p class="empty"><?php echo $this->empty; ?></p>
<?php endif; ?>

</div>
