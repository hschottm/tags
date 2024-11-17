<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?> id="tagscope">
	<ul>
		<li class="reset"><div class="inner"><a href="<?php echo $this->empty_url; ?>"><?php echo $this->lngTags; ?></a></div></li>
<?php if (count($this->arrTags)): ?>
		<li class="tags">
			<ul>
<?php foreach ($this->arrTags as $idx => $tag): ?>
				<li class="tag<?php if ($idx == 1) echo ' first'; ?><?php if ($idx == count($this->arrTags)-1) echo ' last'; ?>">
					<div class="inner">
						<a class="onlytag" href="<?php echo $this->tag_urls[$tag]; ?>"><?php echo $tag; ?></a>
						<a class="removetag" href="<?php echo $this->delete_urls[$tag]; ?>"><span>[x]</span></a>
					</div>
				</li>
<?php endforeach; ?>
			</ul>
		</li>
<?php endif; ?>
		<!--li class="count">
			<strong><em><span class="tagcount">2</span></em> <span class="tagdesc">Bookmarks</span></strong>
		</li-->
	</ul>
</div>
<div style="clear: both;"></div>
