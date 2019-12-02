<?
global $product;
$availability = $product->get_availability();
$class = esc_attr($availability['class']);
$availability = $availability['availability'] ?: 'In stock';
?>
<div class="status <?= $class ?>"><?= $availability ?></div>
