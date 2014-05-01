<footer role="contentinfo">
	<p id="copyright">&copy; Copyright <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
</footer>

</div> <!-- .wrapper -->

<?php wp_footer(); ?>

<?php if( IS_DEV ) : ?>
<script src="//localhost:35729/livereload.js"></script>
<?php endif; ?>
</body>
</html>