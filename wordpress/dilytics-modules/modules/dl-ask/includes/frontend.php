<?php
$c  = dl_contact();
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'ask', 'v-ask-block' ) ); ?>>
	<div class="band-lead g">
		<div class="txt">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 6 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
			<p class="sm hrs"<?php echo dl_rv( 'up', 10 ); ?>><?php echo dl_t( dl_s( $settings, 'hours' ) ); ?></p>
			<div class="acts"<?php echo dl_rv( 'up', 14 ); ?>>
				<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="cta cta-ink"><span><?php echo esc_html( $c['phone'] ?? '' ); ?></span></a>
				<a href="<?php echo esc_attr( 'mailto:' . ( $c['mail'] ?? '' ) ); ?>" class="lnk"><?php echo esc_html( $c['mail'] ?? '' ); ?><?php echo $ar; ?></a>
			</div>
		</div>

		<div class="fw surf"<?php echo dl_rv( 'up', 8 ); ?>>
			<form<?php echo dl_form_attrs( 'question' ); ?>>
				<div class="row">
					<div class="fld">
						<input id="ab-n" name="your-name" type="text" autocomplete="name" placeholder=" " required>
						<label for="ab-n">Nom et prénom</label>
					</div>
					<div class="fld">
						<input id="ab-e" name="your-email" type="email" autocomplete="email" placeholder=" " required>
						<label for="ab-e">E-mail</label>
					</div>
				</div>
				<div class="fld">
					<input id="ab-p" name="your-phone" type="tel" autocomplete="tel" placeholder=" ">
					<label for="ab-p">Téléphone</label>
				</div>
				<div class="fld">
					<textarea id="ab-m" name="your-message" rows="4" placeholder=" " required></textarea>
					<label for="ab-m">Message</label>
				</div>
				<div style="display:none;"><input type="text" name="hp-website" tabindex="-1" autocomplete="off" aria-hidden="true"><input type="hidden" name="hp-t" value=""></div>
				<button type="submit" class="cta cta-red" disabled><span><?php echo dl_t( dl_s( $settings, 'button' ) ); ?></span><?php echo $ar; ?></button>
				<p class="xs err" role="alert" style="display:none;"></p>
			</form>

			<div class="done" style="display:none;">
				<p class="fig ok"><?php echo dl_t( dl_s( $settings, 'done_t' ) ); ?></p>
				<p class="body"><?php echo dl_t( str_replace( '{mail}', $c['mail'] ?? '', dl_s( $settings, 'done_d' ) ) ); ?></p>
				<button class="lnk" type="button"><?php echo dl_t( dl_s( $settings, 'again' ) ); ?><?php echo $ar; ?></button>
			</div>
		</div>
	</div>
</section>
