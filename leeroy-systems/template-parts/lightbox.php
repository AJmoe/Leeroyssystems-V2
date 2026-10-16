<?php
/**
 * Shared modal: photo galleries, story galleries and YouTube videos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="lightbox" data-lightbox-modal hidden role="dialog" aria-modal="true" aria-label="Media viewer">
	<button class="lightbox__close" type="button" data-lightbox-close aria-label="Close"><?php echo leeroy_icon( 'close' ); ?></button>
	<div class="lightbox__inner">
		<div class="lightbox__stage" data-lightbox-stage></div>
		<button class="lightbox__nav lightbox__nav--prev" type="button" data-lightbox-prev aria-label="Previous photo"><?php echo leeroy_icon( 'chevron-left' ); ?></button>
		<button class="lightbox__nav lightbox__nav--next" type="button" data-lightbox-next aria-label="Next photo"><?php echo leeroy_icon( 'chevron-right' ); ?></button>
		<div class="lightbox__caption" data-lightbox-caption></div>
	</div>
</div>
