<div class="venues-event--item clearfix col-xs-12">
    <h2 class="typewriter title"><a href="<?php print $event['event_url'];?>"><?php print $event['title']; ?></a></h2>
    <div class="event-date"><?php print $event['date']; ?></div>
    <div class="venues-event-artists clearfix">
        <div class="row">
            <?php foreach ($event['artists'] as $artist): ?>
                <div class="col-sm-6">
                    <a href="<?php print $artist['url']; ?>"><?php print $artist['image']; ?></a>
                    <div class="artist-card">
                        <h4 class="typewriter title"><a href="<?php print $artist['url']; ?>"><?php print $artist['name']; ?></a></h4>
                        <?php print $artist['genres']; ?>
                    </div>
                </div>
                <?php if($artist['zebra'] == 'odd'):?>
                    <div class="col-sm-12 hidden-xs clearfix margin-bottom-20"></div>
                <?php endif ?>
                <div class="col-xs-12 visible-xs clearfix margin-bottom-20"></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div><a href="<?php print $event['event_url'];?>"><span class="more-button">Learn more...</span></a></div>
</div>