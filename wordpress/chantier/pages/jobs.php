<?php
/**
 * /offres-demploi/ — pages/offres-demploi.vue. The offers are the Nuxt
 * site's sample postings; with an empty list the page shows its own
 * "no position" sentence.
 */

defined( 'ABSPATH' ) || exit;

$c    = dlb_content();
$jobs = $c['components']['jobs'];
$id   = dlb_page( 'offres-demploi' );
dlb_start( $id );
dlb_scope( 'v-offres-demploi' );

dlb_add(
	'dl-jobs-open',
	array_merge(
		array(
			'crumb'  => 'Carrière',
			'lines'  => dlb_lines( array( 'Rejoignez Dilytics', 'et donnez un élan', 'à votre carrière.' ) ),
			'accent' => '2',
			'intro'  => "Chez Dilytics, nous sommes une équipe passionnée, innovante et résolument tournée vers l'avenir, qui valorise ses collaborateurs autant que ses clients.",
			'alt'    => '',
		),
		dlb_photo( 'img', 'duo' )
	)
);

dlb_add(
	'dl-jobs-list',
	array(
		'title'   => 'Postes ouverts.',
		'offers'  => $jobs['offers'],
		'none'    => "Aucun poste n'est ouvert actuellement. Si vous êtes passionné·e, prêt·e à relever des défis et souhaitez faire carrière au sein d'une entreprise qui valorise ses collaborateurs, écrivez-nous.",
		'apply'   => 'Postuler',
		'subject' => 'Candidature : {poste}',
	)
);

dlb_add(
	'dl-jobs-perks',
	array(
		'title' => 'Travailler ici',
		'items' => $jobs['perks'],
	)
);

dlb_cta(
	array(
		'lines' => dlb_lines( array( 'Candidature', 'spontanée ?' ) ),
		'text'  => "Si vous êtes passionné·e, prêt·e à relever des défis et souhaitez faire carrière au sein d'une entreprise qui valorise ses collaborateurs, écrivez-nous.",
		'label' => 'Nous écrire',
		'to'    => '/contact/',
	)
);

dlb_finish( $id );
