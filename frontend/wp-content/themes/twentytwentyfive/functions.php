<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

function lead_capture_form() {
    ob_start(); ?>
    
    <div class="lead-form-container">
        <h2>Dapatkan Penawaran Terbaik!</h2>
        <p>Isi formulir di bawah ini dan kami akan segera menghubungi Anda.</p>

        <form id="lead-form" action="#" method="POST">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required placeholder="Masukkan Nama Anda">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan Email Anda">
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon:</label>
                <input type="text" id="phone" name="phone" required placeholder="Masukkan Nomor HP">
            </div>

            <div class="form-group">
                <label for="source">Sumber (UTM Campaign):</label>
                <input type="text" id="source" name="source" readonly>
            </div>

            <div class="form-group">
                <label for="message">Pesan:</label>
                <textarea id="message" name="message" placeholder="Tulis pesan Anda..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Kirim</button>
            <p id="form-message"></p>
        </form>
    </div>

    <script>
    function getUTMParameter(name) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    let utmSource = getUTMParameter("utm_campaign") || "Tiktok";
    document.getElementById("source").value = utmSource;

    document.getElementById("lead-form").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = {
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            source: document.getElementById("source").value,
            message: document.getElementById("message").value
        };

        fetch("http://localhost:8000/api/leads", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer lead-management-token-2025"
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.id) {
                document.getElementById("form-message").innerText = "✅ Pesan  berhasil dikirim!";
                document.getElementById("form-message").style.color = "green";
                document.getElementById("lead-form").reset();
            } else {
                document.getElementById("form-message").innerText = "❌ Gagal mengirim, coba lagi!";
                document.getElementById("form-message").style.color = "red";
            }
        })
        .catch(error => {
            document.getElementById("form-message").innerText = "⚠️ Terjadi kesalahan, coba lagi!";
            document.getElementById("form-message").style.color = "red";
            console.error("Error:", error);
        });
    });
    </script>

    <style>
        .lead-form-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .lead-form-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .lead-form-container p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: none;
            height: 80px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #0073aa;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #005177;
        }

        #form-message {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>

    <?php
    return ob_get_clean();
}
add_shortcode('lead_capture_form', 'lead_capture_form');
