<?php

class StyleTableSeeder extends Seeder
{
	// SAVE ME THIS FILE IS SO UGLY
	public function run()
	{
		DB::table('styles')->truncate();

		$styles = array(
			array(
				'title' => 'Avenue',
				'slug' => 'avenue',
				'description' => 'modern retro',
				'source' => File::get('app/assets/default-styles/git-uploads/Avenue.css'),
				'format' => 'css',
				'author_id' => 2,
        'created_at' => '2013-11-27 15:54:41'
			),
			array(
				'title' => 'Kult',
				'slug' => 'kult',
				'description' => 'Easy to read',
				'source' => File::get('app/assets/default-styles/git-uploads/kult.css'),
				'format' => 'css',
				'author_id' => 3,
        'created_at' => '2013-11-27 18:05:37'
			),
			array(
				'title' => 'Grump',
				'slug' => 'grump',
				'description' => 'Hard on the outside, soft on the inside',
				'source' => File::get('app/assets/default-styles/git-uploads/Grump.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-26 20:01:06'
			),
			array(
				'title' => 'Ulysses Freestraction Light',
				'slug' => 'ulysses-freestraction-light',
				'description' => 'Based on the Freestraction color scheme used in Ulysses III <http://www.ulyssesapp.com>.
   For more information read the introductory post: http://candlerblog.com/2013/04/11/ulysses-iii-and-marked/ ',
				'source' => File::get('app/assets/default-styles/git-uploads/Ulysses-Freestraction-Light.css'),
				'format' => 'css',
				'author_id' => '5',
        'created_at' => '2013-11-27 09:37:30'
			),
			array(
				'title' => 'Amblin',
				'slug' => 'amblin',
				'description' => 'A clean theme with bold headlines and carefully crafted typography.
Non-standard fonts used:
	* Rockwell (Installed by Microsoft Office)
	* Rokkit (Fallback, available at <http://www.fontsquirrel.com/fontface>)
Download @font-face kits from <http://www.fontsquirrel.com/fontface>. Woff versions included as data uris.',
				'source' => File::get('app/assets/default-styles/amblin.css'),
				'format' => 'css',
				'author_id' => '6',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Antique',
				'slug' => 'antique',
				'description' => 'An "antiqued" theme with off-white background and serif typography',
				'source' => File::get('app/assets/default-styles/antique.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Github',
				'slug' => 'github',
				'description' => 'Github README style. Includes theme for Pygmentized code blocks.',
				'source' => File::get('app/assets/default-styles/github.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Lopash',
				'slug' => 'lopash',
				'description' => 'Clean, bouyant fonts and highly readable text',
				'source' => File::get('app/assets/default-styles/Lopash.css'),
				'format' => 'css',
				'author_id' => '6',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Manuscript',
				'slug' => 'manuscript',
				'description' => 'Courier, Double-spaced, paragraph indent. Use `###### #` to create "#" centered dividers',
				'source' => File::get('app/assets/default-styles/manuscript.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Swiss',
				'slug' => 'swiss',
				'description' => 'Clean, Swiss typography with no frills.',
				'source' => File::get('app/assets/default-styles/swiss.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-27 06:03:05'
			),
			array(
				'title' => 'Upstanding Citizen',
				'slug' => 'upstanding-citizen',
				'description' => 'A modern layout with bold headlines
Non-standard fonts used:
	* OSPDIN
	* League Gothic
	* Fjord
	* Inconsolata
Download @font-face kits from <http://www.fontsquirrel.com/fontface>. Woff versions included as data uris.',
				'source' => File::get('app/assets/default-styles/UpstandingCitizen.css'),
				'format' => 'css',
				'author_id' => '4',
        'created_at' => '2013-11-27 06:03:05'
			),
/* Sample
			array(
				'title' => '',
				'slug' => '',
				'description' => '',
				'source' => '',
				'format' => '',
				'author_id' => ''
			)
*/
		);

    foreach ($styles as &$style) {
      $style['updated_at'] = new DateTime;
    }

		DB::table('styles')
			->insert($styles);
	}
}
