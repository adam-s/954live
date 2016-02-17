<div class="artist">
    <?php print $image; ?>
    <div class="card clearfix">
        <h1 class="typewriter title" style="color: white"><?php print $title?></h1>
        <div class="info row">
            <div class="col-sm-8"><?php print $genres; ?></div>
            <div class="col-sm-4 text-right"><?php print $social; ?></div>
        </div>
    </div>
    <hr/>
    <h3 class="typewriter">#VIDEOS</h3>
    <div class="video clearfix">
        <?php foreach($youtube as $video): ?>
            <div class="col-sm-6"><?php print $video; ?></div>
            <div class="visible-xs margin-bottom-20"></div>
        <?php endforeach; ?>
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