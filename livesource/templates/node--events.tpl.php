<div class="event">
    <header>
        <h1 class="title typewriter"><?php print $event['title']; ?></h1>
        <div class="event-date"><?php print $event['date']; ?></div>
        <div class="event-location"><?php print $event['venue']['location']; ?></div>
    </header>
    <hr />
    <h3 class="typewriter">#VENUE</h3>
    <section class="venue clearfix">
        <a href="<?php print $event['venue']['url']; ?>" alt="<?php print $event['venue']['name']?>" title="<?php print $event['venue']['name']?>">
            <?php print $event['venue']['image']; ?>
        </a>
        <div class="card clearfix">
            <a href="<?php print $event['venue']['url']; ?>" alt="<?php print $event['venue']['name']?>" title="<?php print $event['venue']['name']?>">
                <h2 class="typewriter title h1"><?php print $event['venue']['name']?></h2>
            </a>
            <div class="info row">
                <div class="col-sm-4 hidden-xs">
                    <div class="map"><?php print $event['venue']['map']; ?></div>
                </div>
                <div class="col-sm-8">
                    <div class="address"><?php print $event['venue']['address']; ?></div>
                    <div class="phone"><?php print $event['venue']['phone']; ?></div>
                    <div class="map-link margin-bottom-10 visible-xs">
                        (<a href="<?php print $event['venue']['url']; ?>" alt="<?php print $event['venue']['name']?>" title="<?php print $event['venue']['name']?>">click for map</a>)
                    </div>
                    <div class="social"><?php print $event['venue']['social']; ?></div>
                </div>
            </div>
        </div>
    </section>
    <hr />
    <h3 class="typewriter">#ARTISTS</h3>
    <section class="artists">
        <?php foreach($event['artists'] as $artist): ?>
            <div class="artist">
                <a href="<?php print $artist['url']; ?>" title="<?php print $artist['name']?>" alt="<?php print $artist['name']?>">
                    <?php print $artist['image']; ?>
                </a>
                <div class="card clearfix">
                    <a href="<?php print $artist['url']; ?>" title="<?php print $artist['name']?>" alt="<?php print $artist['name']?>">
                        <h2 class="typewriter title h1" style="color: white"><?php print $artist['name']?></h2>
                    </a>
                    <div class="margin-bottom-20 visible-xs"></div>
                    <div class="row">
                        <div class="youtube col-sm-6 col-sm-push-6">
                            <?php print $artist['youtube'][0]; ?>
                        </div>
                        <div class="margin-bottom-20 visible-xs"></div>
                        <div class="info col-sm-6 col-sm-pull-6">
                            <?php if(!empty($artist['genres'])):?>
                                <div class="genres"><?php print $artist['genres']; ?></div>
                            <?php endif; ?>
                            <div class="social"><?php print $artist['social']; ?></div>
                            <div class="margin-bottom-10"><a class="more-button" href="<?php print $artist['url'];?>"><span>Learn more...</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
    </section>
</div>