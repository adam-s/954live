<div class="event-item">
    <a href="<?php print $url; ?>"><?php print $image; ?></a>
    <div class="card clearfix">
        <a href="<?php print $url; ?>"><h4 class="typewriter title" style="color: white"><?php print $title?></h4></a>
        <div class="clearfix">
            <span class="event-date"><?php print $date; ?></span>
            <span class="hidden-xs"> | </span><div class="visible-xs"></div>
            <span class="event-location"><?php print $venue['location']; ?></span>
        </div>
        <div class="venue-name">
            <a href="<?php print $venue['url']; ?>"><span class="red-highlight">@</span> <?php print $venue['name']; ?></a>
        </div>
        <?php foreach ($artists as $artist): ?>
            <div><a href="<?php print $artist['url']; ?>"><span class="red-highlight">//</span> <?php print $artist['name']; ?></a></div>
        <?php endforeach; ?>
        <a href="<?php print $url;?>"><span class="more-button pull-right">Learn more...</span></a>
    </div>
</div>
<hr/>
