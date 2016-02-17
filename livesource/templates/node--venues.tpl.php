<div class="venue">
    <?php print $image; ?>
    <div class="card clearfix">
        <h1 class="typewriter title"><?php print $name?></h1>
        <div class="info row">
            <div class="col-sm-4 hidden-xs">
                <div class="map"><?php print $map; ?></div>
            </div>
            <div class="col-sm-8">
                <div class="address"><?php print $address; ?></div>
                <div class="phone margin-bottom-10"><?php print $phone; ?></div>
                <div class="social"><?php print $social; ?></div>
            </div>
        </div>
    </div>
    <hr/>
    <?php if (!empty($about)): ?>
        <h3 class="typewriter">#ABOUT</h3>
        <div class="about typewriter clearfix">
            <div class="col-xs-12">
                <?php print $about; ?>
            </div>
        </div>
        <hr/>
    <?php endif; ?>
    <?php if (!empty($events)):?>
        <div class="events clearfix">
            <h3 class="typewriter">#UPCOMING EVENTS</h3>
            <?php foreach($events as $event): ?>
                <?php print $event; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>