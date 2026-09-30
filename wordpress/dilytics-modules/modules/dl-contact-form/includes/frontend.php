<?php
$c  = dl_contact();
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'bay', 'v-contact' ) ); ?>>
	<div class="wrap cg">
		<div class="fw"<?php echo dl_rv( 'up' ); ?>>
			<form class="form"<?php echo dl_form_attrs( 'contact' ); ?>>
				<div class="row">
					<div class="fld">
						<input id="n" name="your-name" type="text" autocomplete="name" placeholder=" " required>
						<label for="n">Votre nom</label>
					</div>
					<div class="fld">
						<input id="e" name="your-email" type="email" autocomplete="email" placeholder=" " required>
						<label for="e">Adresse e-mail</label>
					</div>
				</div>
				<div class="row">
					<div class="fld">
						<input id="p" name="your-phone" type="tel" autocomplete="tel" placeholder=" ">
						<label for="p">Téléphone (facultatif)</label>
					</div>
					<div class="fld">
						<select id="s" name="your-subject">
							<option value="" disabled selected>Choisir un sujet</option>
							<?php foreach ( dl_lines( dl_s( $settings, 'subjects' ) ) as $s ) : ?>
								<option value="<?php echo esc_attr( $s ); ?>"><?php echo esc_html( $s ); ?></option>
							<?php endforeach; ?>
						</select>
						<label for="s" class="up">Sujet</label>
					</div>
				</div>
				<div class="fld">
					<textarea id="m" name="your-message" rows="5" placeholder=" " required></textarea>
					<label for="m">Votre message</label>
				</div>
				<div style="display:none;"><input type="text" name="hp-website" tabindex="-1" autocomplete="off" aria-hidden="true"><input type="hidden" name="hp-t" value=""></div>
				<div class="sub">
					<button type="submit" class="cta cta-ink" disabled><span><?php echo dl_t( dl_s( $settings, 'button' ) ); ?></span><?php echo $ar; ?></button>
					<p class="xs"><?php echo dl_t( dl_s( $settings, 'note' ) ); ?></p>
				</div>
				<p class="xs err" role="alert" style="display:none;"></p>
			</form>

			<div class="done" style="display:none;">
				<h2 class="d3"><?php echo dl_t( dl_s( $settings, 'done_t' ) ); ?></h2>
				<p class="body"><?php echo dl_t( str_replace( '{mail}', $c['mail'] ?? '', dl_s( $settings, 'done_d' ) ) ); ?></p>
				<button class="lnk" type="button"><?php echo dl_t( dl_s( $settings, 'again' ) ); ?><?php echo $ar; ?></button>
			</div>
		</div>

		<aside class="side"<?php echo dl_rv( 'up', 8 ); ?>>
			<div class="blk">
				<h2 class="t2"><?php echo dl_t( dl_s( $settings, 'call_t' ) ); ?></h2>
				<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="big"><?php echo esc_html( $c['phone'] ?? '' ); ?></a>
				<p class="sm"><?php echo esc_html( $c['hours'] ?? '' ); ?></p>
			</div>
			<div class="blk">
				<h2 class="t2"><?php echo dl_t( dl_s( $settings, 'write_t' ) ); ?></h2>
				<a href="<?php echo esc_attr( 'mailto:' . ( $c['mail'] ?? '' ) ); ?>" class="lnk"><?php echo esc_html( $c['mail'] ?? '' ); ?><?php echo $ar; ?></a>
			</div>
			<div class="blk">
				<h2 class="t2"><?php echo dl_t( dl_s( $settings, 'visit_t' ) ); ?></h2>
				<p class="sm"><?php echo esc_html( $c['street'] ?? '' ); ?><br><?php echo esc_html( $c['city'] ?? '' ); ?></p>
				<p class="xs"><?php echo dl_t( dl_s( $settings, 'visit_d' ) ); ?></p>
			</div>
		</aside>
	</div>
</section>
