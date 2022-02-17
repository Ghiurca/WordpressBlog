
<?php


/**
 * Enqueue scripts and styles.
 */
function iap_scripts() {
    wp_enqueue_style( 'style', untrailingslashit( get_template_directory_uri() ) . '/style.css' );
    
    wp_enqueue_style( 'font-google', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap', false ); 
}
add_action( 'wp_enqueue_scripts', 'iap_scripts' );


/**
 * Theme Setup
 */

if (!function_exists('iap_setup') ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function iap_setup() {
        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support( 'title-tag' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 191,
				'height'      => 67,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

        // Menu locations
		register_nav_menus(
			array(
				'menu' => __( 'Header', 'iap' ),
			)
		);

        // Add support for featured image
        add_theme_support('post-thumbnails');

        // Set featured image size
        set_post_thumbnail_size(343, 235, true);
    }
endif;

add_action( 'after_setup_theme', 'iap_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iap_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'iap' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your footer.', 'iap' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'iap_widgets_init' );

/**
 * Filter the except length to 20 words.
 *
 * @link https://developer.wordpress.org/reference/functions/the_excerpt/
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */

function iap_excerpt_length( $length ) {
    return 15;
}

add_filter('excerpt_length', 'iap_excerpt_length', 999);


/**
 * Gutenberg Blocks
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;

function iap_attach_gutenberg_blocks() {

    Block::make('IAP Hero')
        -> add_fields([
            Field::make('text', 'iap_hero_title', __( 'Title' )),
            Field::make('rich_text', 'iap_hero_content', __( 'Content' )),
            Field::make('text', 'iap_hero_button', __( 'Button' )),
            Field::make( 'image', 'iap_hero_image', __( 'Imagine' ) )
        ])
        -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class = "hero">
    <div class = "container">
        <div class = "inner-hero">
            <div class = "hero-description">
                <h2 class = "hero-title" ><?= $fields['iap_hero_title'] ?></h2>
                <p class = "hero-p"><?= $fields['iap_hero_content'] ?></p>
                <button class = "buton"><?= $fields['iap_hero_button'] ?></button>
            </div>
            <a class="header-logo" href="/"><?= wp_get_attachment_image( $fields['iap_hero_image'], 'full' ); ?></a>
        </div>
    </div>
</div>
        <?php
    });

	
	Block::make('IAP Section')
        -> add_fields([
            Field::make( 'text', 'iap_section_title', __( 'Title' ) ),
            Field::make( 'text', 'iap_section_text', __( 'Text' ) ),
            Field::make( 'complex', 'iap_section_cards', __( 'Cards' ) )
                -> add_fields([
                    Field::make( 'image', 'iap_section_cards_image', __( 'Image' ) ),
                    Field::make( 'text', 'iap_section_cards_title', __( 'Title' ) ),
                    Field::make( 'text', 'iap_section_cards_text', __( 'Text' ) )
                ]),
                Field::make('text', 'iap_section_button', __( 'Button' ))
        ])
		-> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class = "hero-2">
    <div class = "container">
        <div class="inner-hero-2">
            <div class="hero2-title">
                <h2 class = "hero-title"><?= $fields['iap_section_title'] ?></h2>
                <p class = "hero-p"><?= $fields['iap_section_text'] ?></p>
            </div>
            <?php if($fields['iap_section_cards']): ?>
            <div class = "hero-cards">
            <?php foreach($fields['iap_section_cards'] as $field): ?>
                <div class ="card">
                    <div class = "inner-card">
                    <a class="card-image" href="/"><?= wp_get_attachment_image( $field['iap_section_cards_image'], 'full' ); ?></a>
                    <h2 class = "card-title"><?= $field['iap_section_cards_title'] ?></h2>
                    <p class="card-description"><?= $field['iap_section_cards_text'] ?></p>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php endif ?>
            <div class = "hero-buton">
                <button class = "buton2"><?= $fields['iap_section_button'] ?></button>
            </div>
        </div>

    </div>
</div>
		<?php
	});

    Block::make('IAP ilustrate')
    -> add_fields([
        Field::make('text', 'iap_ilustrate_title', __( 'Title' )),
        Field::make('rich_text', 'iap_ilustrate_content', __( 'Content' )),
        Field::make('text', 'iap_ilustrate_button', __( 'Button' )),
        Field::make( 'image', 'iap_ilustrate_image', __( 'Imagine' ) )
    ])
    -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
        <div class ="illustrate">
    <div class = "container">
        <div class = "inner-illustrate">
            <div class = "illustrate-image">
            <a class="illustrate-imagine" href="/"><?= wp_get_attachment_image( $fields['iap_ilustrate_image'], 'full' ); ?></a>
            </div>
            <div class = "illustrate-text">
                <h2 class = "card-title"><?= $fields['iap_ilustrate_title'] ?></h2>
                <p class = "card-description"><?= $fields['iap_ilustrate_content'] ?></p>
                <button class = "buton2"><?= $fields['iap_ilustrate_button'] ?></button>

            </div>
        </div>
    </div>
</div>
    <?php
});
Block::make('IAP ilustrate2')
-> add_fields([
    Field::make('text', 'iap_ilustrate_title', __( 'Title' )),
    Field::make('rich_text', 'iap_ilustrate_content', __( 'Content' )),
    Field::make('text', 'iap_ilustrate_button', __( 'Button' )),
    Field::make( 'image', 'iap_ilustrate_image', __( 'Imagine' ) )
])
-> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
   <div class ="illustrate">
    <div class = "container">
        <div class = "inner-illustrate">
            
            <div class = "illustrate-text">
                <h2 class = "card-title"><?= $fields['iap_ilustrate_title'] ?></h2>
                <p class = "card-description"><?= $fields['iap_ilustrate_content'] ?></p>
                <button class = "buton2"><?= $fields['iap_ilustrate_button'] ?></button>

            </div>
            <div class = "illustrate-image">
            <a class="illustrate-imagine" href="/"><?= wp_get_attachment_image( $fields['iap_ilustrate_image'], 'full' ); ?></a>
            </div>
    
        </div>
    </div>
</div>
<?php
});
Block::make('IAP profile')
-> add_fields([
    Field::make('text', 'iap_profile_title', __( 'Title' )),
    Field::make('text', 'iap_profile_name', __( 'Name' )),
    Field::make('text', 'iap_profile_role', __( 'role' )),
    Field::make('rich_text', 'iap_profile_content', __( 'Content' )),
    Field::make( 'image', 'iap_profile_image', __( 'Imagine' ) )
])
-> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
   <div class = "profile">
    <div class = "container">
        <div class ="inner-profile" >
            <div class = "profile-title">
                <h2><?= $fields['iap_profile_title'] ?></h2>
            </div>
            <div class = "profile-description">
            <a class="illustrate-imagine" href="/"><?= wp_get_attachment_image( $fields['iap_profile_image'], 'full' ); ?></a>
            <div class="profile-name">
            <h2><?= $fields['iap_profile_name'] ?></h2>
            <p><?= $fields['iap_profile_role'] ?></p>
            </div>
            <p><?= $fields['iap_profile_content'] ?></p>
            </div>
        </div>
        <div class ="scroll">
        <i id = "arrow" class="fas fa-arrow-left"></i>
        <div class = "dots">
        <i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i>
        </div>
        <i id = "arrow" class="fas fa-arrow-right"></i>
        </div>
    </div> 
</div>
<?php
});
Block::make('IAP articles')
        -> add_fields([
            Field::make( 'text', 'iap_articles_title', __( 'Title' ) ),
            Field::make( 'complex', 'iap_articles_cards', __( 'Cards' ) )
                -> add_fields([
                    Field::make( 'image', 'iap_articles_cards_image', __( 'Image' ) ),
                    Field::make( 'text', 'iap_articles_cards_title', __( 'Title' ) ),
                    Field::make( 'text', 'iap_articles_cards_text', __( 'Text' ) )
                ]),
                Field::make('text', 'iap_articles_button', __( 'Button' ))
        ])
		-> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class = "hero-2">
    <div class = "container">
        <div class="inner-hero-2">
            <div class="hero2-title">
                <h2 class = "hero-title"><?= $fields['iap_articles_title'] ?></h2>
            </div>
            <?php if($fields['iap_articles_cards']): ?>
            <div class = "hero-cards">
            <?php foreach($fields['iap_articles_cards'] as $field): ?>
                <div class ="card">
                    <div class = "inner-card">
                    <a class="card-image" href="/"><?= wp_get_attachment_image( $field['iap_articles_cards_image'], 'full' ); ?></a>
                    <h2 class = "card-title"><?= $field['iap_articles_cards_title'] ?></h2>
                    <p class="card-description"><?= $field['iap_articles_cards_text'] ?></p>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php endif ?>
            <div class = "hero-buton">
                <button class = "buton2"><?= $fields['iap_articles_button'] ?></button>
            </div>
        </div>

    </div>
</div>
		<?php
	});
}

add_action('carbon_fields_register_fields', 'iap_attach_gutenberg_blocks' );
