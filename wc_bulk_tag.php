<?php
/**
 * Plugin Name: Bulk Tag Updater Woocommerce
 * Description: Worpress plugin pentru redactarea bulk a tagului pentru produce Woocomerce.
 * Version: 1.0.0
 * Author: Dolghieru Maxim
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Bulk_Tag_Updater {
    
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function init() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
            return;
        }
        
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'add_promo_field' ) );
        add_action( 'woocommerce_process_product_meta', array( $this, 'save_promo_field' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'load_styles') );
        add_filter( 'posts_search', array( $this, 'search_by_title_only' ), 10, 2 );
    }

    public function load_styles($hook){
        if(
            $hook != 'woocommerce_page_product-tag-manager'
        )
        {
            return;
        }
        wp_enqueue_style(
            'product-tag-manager',
            plugin_dir_url(__FILE__) . 'assets/css/admin.css',
            array(),
            '1.0.0'
        );
    }

    public function search_by_title_only( $search, $wp_query ) {
        if ( ! isset( $wp_query->query_vars['search_prod_title_only'] ) ) {
            return $search;
        }
        
        global $wpdb;
        
        if ( empty( $search ) ) {
            return $search;
        }
        
        $search_term = $wp_query->get( 's' );
        if ( empty( $search_term ) ) {
            return $search;
        }
        
        $search = '';
        $search .= " AND (";
        $search .= $wpdb->prepare( "{$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $search_term ) . '%' );
        $search .= ")";
        
        return $search;
    }

    public function woocommerce_missing_notice() {
        ?>
        <div class="notice notice-error">
            <p>Bulk Tag Updater necesită WooCommerce pentru a funcționa! Te rog instalează și activează WooCommerce.</p>
        </div>
        <?php
    }

    public function add_admin_menu() {
        add_submenu_page( 'woocommerce', 'Product Tag Update', 'Product Tag', 'manage_woocommerce', 'product-tag-manager', array( $this, 'display_tag_update_page' ) );
    }

    public function display_tag_update_page() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_die( 'Nu ai acces la pagina data!' );
        }

        $this->handle_single_update();
        $this->handle_bulk_update();
        $this->handle_update_all();

        $paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 10,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        if ( isset( $_GET['search'] ) && ! empty( $_GET['search'] ) ) {
            $args['s'] = sanitize_text_field( $_GET['search'] );
            $args['search_prod_title_only'] = true;
        }

        if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => sanitize_text_field( $_GET['category'] )
                )
            );
        }

        $products = new WP_Query( $args );

        $this->render_page( $products, $paged );
    }

    private function handle_single_update() {
        if ( isset( $_POST['update_product'] ) && isset( $_POST['my_nonce'] ) ) {
            if ( wp_verify_nonce( $_POST['my_nonce'], 'update_product_action' ) ) {
                $product_id = absint( $_POST['product_id'] );
                $new_tag = sanitize_text_field( $_POST['new_tag'] );

                update_post_meta( $product_id, '_promo_tag', $new_tag );
                echo '<div class="notice notice-success"><p>Tagurile au fost actualizate cu succes!</p></div>';
            }
        }
    }

    private function handle_bulk_update() {
        if ( isset( $_POST['bulk_update'] ) && isset( $_POST['bulk_nonce'] ) ) {
            if ( wp_verify_nonce( $_POST['bulk_nonce'], 'bulk_update_action' ) ) {
                $product_ids = isset( $_POST['product_ids'] ) ? array_map( 'absint', $_POST['product_ids'] ) : array();
                $bulk_tag = sanitize_text_field( $_POST['bulk_tag'] );

                if ( empty( $bulk_tag ) ) {
                    echo '<div class="notice notice-error"><p>Te rog introdu un tag!</p></div>';
                    return;
                }

                if ( empty( $product_ids ) ) {
                    echo '<div class="notice notice-error"><p>Te rog selectează cel puțin un produs!</p></div>';
                    return;
                }

                $count = 0;
                foreach ( $product_ids as $product_id ) {
                    $product = wc_get_product( $product_id );
                    if ( ! $product ) {
                        continue;
                    }
                    
                    update_post_meta( $product_id, '_promo_tag', $bulk_tag );
                    $count++;
                }
                echo '<div class="notice notice-success"><p>' . $count . ' producte au fost modificate!</p></div>';
            }
        }
    }

    private function handle_update_all(){
        if (isset($_POST['update_all']) && isset($_POST['update_all_nonce'])){

        if (wp_verify_nonce( $_POST['update_all_nonce'], 'update_all_action' )){

        $all_tag= sanitize_text_field( $_POST['all_tag'] );

        if(empty($all_tag)){
            echo '<div class="notice notice-error"><p> Introdu un tag</p></div>';
            return;
        }
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        if (isset($_GET['search']) && !empty($_GET['search'])){
            $args['s'] = sanitize_text_field( $_GET['search'] );
            $args['search_prod_title_only'] = true;
        }

        if (isset($_GET['category']) && !empty($_GET['category'])){
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => sanitize_text_field( $_GET['category'] )
                )
            );
        }

        $all_products = new WP_Query($args);

        $count = 0;
        if($all_products -> have_posts(  )){
            while($all_products -> have_posts(  )){
                $all_products -> the_post();
                global $post;
                update_post_meta( $post->ID, '_promo_tag', $all_tag );
                $count++;
            }
            wp_reset_postdata(  );
        }
        echo '<div class="notice notice-success"><p>' . $count . ' produse au fost modificate!</p></div>';

        }
        }
    }

    private function render_page( $products, $paged ) {
        ?>
        <div class="wrap product-tag-manager">
            <h1>Product Tag Updater</h1>
            <form method="get" class="filter-form">
                <input type="hidden" name="page" value="product-tag-manager">
                <input type="text" name="search" placeholder="Cauta produse" value="<?php echo isset( $_GET['search'] ) ? esc_attr( $_GET['search'] ) : ''; ?>">

                

                <select name="category">
                    <option value="">Filtreaza dupa categorie</option>
                    <?php
                    $categories = get_terms( array( 'taxonomy' => 'product_cat' ) );
                    foreach ( $categories as $cat ) {
                        $selected = isset( $_GET['category'] ) && $_GET['category'] == $cat->slug ? 'selected' : '';
                        echo '<option value="' . esc_attr( $cat->slug ) . '" ' . $selected . '>' . esc_html( $cat->name ) . '</option>';
                    }
                    ?>
                </select>

                <button type="submit" class="button">Filtreaza</button>
                <a href="?page=product-tag-manager" class="button">Reseteaza</a>
            </form>

            <form method="post" id='bulk-form'>
                <?php wp_nonce_field( 'bulk_update_action', 'bulk_nonce' ); ?>
                
                
                <div class="bulk-actions">
                    <input type="text" name="bulk_tag" placeholder="Introdu Tag-ul">
                    <button type="submit" name="bulk_update" class="button button-primary">Actualizează selectate</button>

                    <span style='margin: 0 10px'>|</span>

                    <input type="text" name="all_tag" placeholder="Introdu Tag-ul penturu toate">
                    <?php wp_nonce_field( 'update_all_action', 'update_all_nonce' ); ?>
                    <button type="submit" name="update_all" class="button button-secondary">Actualizează toate</button>
                </div>
                <table class="product-table striped">
                    <thead>
                        <tr>
                            <th class="product-checkbox"><input type="checkbox" id="select-all"></th>
                            <th>Imagine</th>
                            <th style="text-align: left;">Produsul</th>
                            <th class="product-stock">Stoc</th>
                            <th class="product-price">Pret</th>
                            <th>Actiune</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ( $products->have_posts() ) :
                        while ( $products->have_posts() ) : $products->the_post();
                            global $post;
                            $product = wc_get_product( $post->ID );
                            $tag = get_post_meta( $post->ID, '_promo_tag', true );
                            ?>
                            <tr>
                                <td class="product-checkbox"><input type="checkbox" name="product_ids[]" value="<?php echo esc_attr( $post->ID ); ?>"> </td>
                                <td class="product-image"><?php echo $product->get_image(); ?></td>
                                <td>
                                    <a href="<?php echo esc_url( get_edit_post_link( $post->ID ) ); ?>" class="product-title"><?php echo esc_html( $product->get_name() ); ?></a>
                                    <div class="row-actions">
                                        <span class="edit">
                                            <a href="<?php echo esc_url( get_edit_post_link( $post->ID ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $product->get_name() ) ); ?>">Edit</a> |
                                        </span>
                                        <span class="view">
                                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" target="_blank" rel="bookmark" aria-label="<?php echo esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $product->get_name() ) ); ?>">View</a>
                                        </span>
                                    </div>
                                </td>
                                <td class="product-stock"><?php     
                                $stock_status = $product->get_stock_status();
                                if($stock_status ==='instock'){
                                    echo '<span class="stock-instock">In Stoc</span>';
                                } elseif($stock_status === 'outofstock'){
                                    echo '<span class="stock-outofstock">Indisponibil</span>';
                                } else {
                                    echo '<span class="stock-onorder">Pe comanda</span>';
                                }
                                ?></td>
                                <td class="product-price"><span><?php echo wc_price( $product->get_price() ); ?></span></td>
                                <td class="product-action">
                                    <form method="post" style="display:inline-flex; gap=5px;">
                                        <?php wp_nonce_field( 'update_product_action', 'my_nonce' ); ?>

                                        <input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>">

                                        <input type="text" name="new_tag" placeholder="-" value="<?php echo esc_attr($tag); ?>" style="width: 100px;">
                                        <button type="submit" name="update_product" class="button">Save</button>
                                    </form>
                                </td>
                            </tr>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                    </tbody>
                </table>
            </form>

            <?php            
            if ( $products->max_num_pages > 1 ) {
                echo '<div class="tablepag"><div class="tablepag_pages">';
                echo paginate_links( array(
                    'base' => add_query_arg( 'paged', '%#%' ),
                    'current' => $paged,
                    'total' => $products->max_num_pages,
                    'prev_text' => 'Prev',
                    'next_text' => 'Next'
                ) );
                echo '</div></div>';
            }
            ?>

            <script>
                document.getElementById('select-all').addEventListener('click', function(){
                    var checkboxes = document.querySelectorAll('input[name="product_ids[]"]');
                    checkboxes.forEach(function(checkbox){
                        checkbox.checked = this.checked;
                    }, this);
                });
            </script>
        </div>
        <?php
    }

    public function add_promo_field() {
        global $post;
        $current_value = get_post_meta( $post->ID, '_promo_tag', true );

        woocommerce_wp_text_input( array(
            'id' => '_promo_tag',
            'label' => 'Tag',
            'placeholder' => 'e.g., New, Sale, Featured',
            'description' => 'Adauga un tag pentru acest produs.',
            'value' => $current_value
        ) );
    }

    public function save_promo_field( $product_id ) {
        if ( isset( $_POST['_promo_tag'] ) ) {
            $tag = sanitize_text_field( $_POST['_promo_tag'] );
            update_post_meta( $product_id, '_promo_tag', $tag );
        }
    }
}

// Initialize the plugin
new WC_Bulk_Tag_Updater();
