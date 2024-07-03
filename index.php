<?php get_header(); ?>
<a href=""></a>
<div class="hero_head">
    
    <h1  class=" hero-container event">PHOTOGRAPHE EVENT</h1>
    <?php
include ('templates_part/photo_couv.php')
?>

</div>
<div class="espace-photo-index">


<select name="category-filter" id="category-filter">
        <option value="">Catégories</option>
        <?php
        $categories = get_categories(array('taxonomy' => 'categorie', 'hide_empty' => false));
        foreach ($categories as $category) {
            echo '<option value="' . esc_attr($category->term_id) . '" class="category-option" id="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
        }
        ?>
    </select>

    <select name="format-filter" id="format-filter">
        <option value="">Formats</option>
        <?php
        $formats = get_categories(array('taxonomy' => 'format', 'hide_empty' => false));
        foreach ($formats as $format) {
            echo '<option value="' . esc_attr($format->term_id) . '" class="format-option" id="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</option>';
        }
        ?>
    </select>

    <select name="order-filter" id="order-filter">
        <option value="">Trier par</option>
        <option value="DESC">Plus récentes</option>
        <option value="ASC">Plus anciennes</option>
    </select>
</div>



</div>
<div class="photo-apparenté2">
<?php
include ('templates_part/photo_block.php')
?>
<div class="pos-button">
<button id="charger-plus-btn">Charger plus</button>
</div>
</div>
<?php get_footer(); ?>