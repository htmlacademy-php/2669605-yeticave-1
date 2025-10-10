<main>
    <section class="lot-item container">
        <h2><?= $lot['name'] ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="../<?= htmlspecialchars($lot['image']) ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['category_name']) ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars($lot['description']) ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <?php $time_left = get_dt_range($lot["completion_date"]); ?>
                    <div class="lot-item__timer timer <?= $time_left['hours'] <= 1 ? ' timer--finishing' : '' ?>">
                        <?= str_pad(
                            $time_left['hours'], 2, '0', STR_PAD_LEFT)
                        . ':'
                        . str_pad($time_left['minutes'], 2, '0', STR_PAD_LEFT) ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= priceFormat((float)$lot['initial_price']) ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= priceFormat((float)$lot['step_size']) ?></span>
                        </div>
                    </div>
                </div>

        </div>
    </section>
</main>
