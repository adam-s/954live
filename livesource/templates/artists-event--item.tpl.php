<div class="artists-event--item clearfix col-xs-12">
    <div class="col-sm-5 hidden-xs">
        <a href="<?php print $event['event_url'];?>"><?php print $event['image']; ?></a>
    </div>
    <div class="col-sm-7">
        <div class="clearfix">
            <h3 class="event-date"><?php print $event['date']; ?></h3>
            <div><?php print $event['location']; ?></div>
            <div class="venue-name">
                <a href="<?php print $event['venue_url']; ?>"><span class="red-highlight">@</span> <?php print $event['venue']; ?></a>
            </div>
            <?php foreach ($event['artists'] as $artist): ?>
                <div><a href="<?php print $artist['url']; ?>"><span class="red-highlight">//</span> <?php print $artist['name']; ?></a></div>
            <?php endforeach; ?>
            <a class="more-button" href="<?php print $event['event_url'];?>"><span>Learn more...</span></a>
        </div>
    </div>
    <div class="col-xs-12"></div>
</div>