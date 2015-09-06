<!-- Search Form -->
<div id="search-form" class="row">
    <div class="small-12 small-centered columns">
        <form action="/api/search" method="get" autocomplete="off" ajax="true">
            <div class="row">
                <div class="small-8 columns">
                    <!-- Search `text` -->
                    <div class="row">
                        <div class="small-12 columns">
                            <label>
                                <strong>Text:</strong>
                                <input type="text" name="text" placeholder="Enter text">
                            </label> 
                        </div>
                    </div>
                    <!-- Search `location` -->
                    <div class="row">
                        <div class="small-12 columns">
                            <label>
                                <strong>Location:</strong>
                                <input type="text" name="location" placeholder="Enter location">
                            </label> 
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="row">
                        <div class="small-12 columns">
                            <div class="row"> 
                                <div class="small-5 columns"> 
                                    <input type="submit" name="search" id="search" class="button left" value="Search">
                                </div>
                                <div id="loadingimg" class="small-3 columns">
                                    <img src="http://dev.cloudcell.co.uk/bin/loading.gif"/>
                                </div>
                                <div class="view-all small-4 columns" style="font-size: 0.9em;">
                                    &rsaquo; <a href="/api/tweets" target="_blank" alt="View all tweets">View all tweets</a>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </form>
    </div>
</div>