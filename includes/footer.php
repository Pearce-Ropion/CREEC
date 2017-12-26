<footer>
	<div class="footer-inner">
		<p>
			&copy; Copyright
			<?php if (date('Y') == 2017): ?>
				2017
			<?php else: ?>
				2017 - <?php echo date('Y'); ?>;
			<?php endif; ?>
			________ | All Rights Reserved
		</p>
		<p class="small">Web Application Built and Designed by <a href="http://www.pearce-ropion.com/contact" target="_blank">Pearce Ropion</a></p>
	</div>
	<?php $sql->close(); ?>
</footer>
