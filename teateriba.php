<?php
/**
 * Plugin Name: Aalase teateriba
 * Description: Kuvab lehe ülaosas teateriba
 * Version: 1.5
 * Author: Aallas
 */

if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_menu_page('Aalase teateriba', 'Aalase teateriba', 'manage_options', 'teateriba', 'teateriba_admin_page');
});

add_action('admin_init', function() {
    register_setting('teateriba_group', 'teateriba_text');
    register_setting('teateriba_group', 'teateriba_bg');
    register_setting('teateriba_group', 'teateriba_color');
    register_setting('teateriba_group', 'teateriba_only_home');
});

function teateriba_admin_page() { ?>
    <div class="wrap">
        <h1>Aalase teateriba</h1>
        <form method="post" action="options.php">
            <?php settings_fields('teateriba_group'); ?>
            <table class="form-table">
                <tr><th>Tekst</th><td><input type="text" name="teateriba_text" value="<?php echo esc_attr(get_option('teateriba_text', '')); ?>" style="width:400px"></td></tr>
                <tr><th>Taustavärv</th><td><input type="color" name="teateriba_bg" value="<?php echo esc_attr(get_option('teateriba_bg', '#e63946')); ?>"></td></tr>
                <tr><th>Teksti värv</th><td><input type="color" name="teateriba_color" value="<?php echo esc_attr(get_option('teateriba_color', '#ffffff')); ?>"></td></tr>
                <tr><th>Ainult avalehel</th><td><input type="checkbox" name="teateriba_only_home" value="1" <?php checked(1, get_option('teateriba_only_home', 0)); ?>></td></tr>
            </table>
            <?php submit_button('Salvesta'); ?>
        </form>
    </div>
<?php }

add_action('wp_head', function() {
    $only_home = get_option('teateriba_only_home', 0);
    $text = get_option('teateriba_text', '');
    if (!$text) return;
    if ($only_home && !is_front_page()) return;

    $bg       = esc_attr(get_option('teateriba_bg', '#e63946'));
    $color    = esc_attr(get_option('teateriba_color', '#ffffff'));
    $is_front = is_front_page() ? 'true' : 'false';
    $text_html = esc_html($text);
    ?>
    <style>
        #teateriba-bar {
            background: <?php echo $bg ?> !important;
            color: <?php echo $color ?> !important;
            width: 100% !important;
            padding: 12px 50px !important;
            text-align: center !important;
            position: relative !important;
            box-sizing: border-box !important;
            font-size: 16px !important;
            z-index: 999999 !important;
            margin: 0 !important;
        }
        #teateriba-close {
            position: absolute !important;
            right: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: none !important;
            border: none !important;
            color: <?php echo $color ?> !important;
            font-size: 24px !important;
            cursor: pointer !important;
            line-height: 1 !important;
            padding: 0 !important;
        }
        #teateriba-floatbtn {
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            background: <?php echo $bg ?> !important;
            color: <?php echo $color ?> !important;
            border: none !important;
            padding: 10px 18px !important;
            cursor: pointer !important;
            border-radius: 4px !important;
            font-size: 14px !important;
            z-index: 999999 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3) !important;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var hidden = localStorage.getItem('teateriba_hidden') === '1';
        var isFront = <?php echo $is_front ?>;

        var bar = document.createElement('div');
        bar.id = 'teateriba-bar';
        bar.innerHTML = '<span><?php echo $text_html ?></span><button id="teateriba-close">&times;</button>';
        bar.style.display = hidden ? 'none' : 'block';
        document.body.insertBefore(bar, document.body.firstChild);

        document.getElementById('teateriba-close').onclick = function() {
            bar.style.display = 'none';
            localStorage.setItem('teateriba_hidden', '1');
            if (isFront) floatBtn.style.display = 'block';
        };

        if (isFront) {
            var floatBtn = document.createElement('button');
            floatBtn.id = 'teateriba-floatbtn';
            floatBtn.textContent = hidden ? 'Näita teadet' : 'Peida teade';
            document.body.appendChild(floatBtn);

            floatBtn.onclick = function() {
                if (bar.style.display === 'none') {
                    bar.style.display = 'block';
                    localStorage.setItem('teateriba_hidden', '0');
                    floatBtn.textContent = 'Peida teade';
                } else {
                    bar.style.display = 'none';
                    localStorage.setItem('teateriba_hidden', '1');
                    floatBtn.textContent = 'Näita teadet';
                }
            };
        }
    });
    </script>
    <?php
});
