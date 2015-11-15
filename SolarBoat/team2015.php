<?php include('head.php') ?>
<?php include('navigation.php') ?>

<script src="Scripts/team-scripts.js" type="text/javascript"></script>

<div class="wrapper-main">
    <section class="featured">
        <div class="content-wrapper-sub">
            <hgroup class="title">
                <h1>Team</h1>
            </hgroup>
        </div>
    </section>
    <section class="content-wrapper-sub main-content main-content-sub clear-fix">
        <div class="col-sm-12 team-grid">
            <div class="col-sm-2" id="team-nav">
                <div class="team-year-nav">
                    <a href="team2015.php">2015</a>
                </div>
                <div class="team-year-nav">
                    <a href="team2014.php">2014</a>
                </div>
                <div class="team-year-nav">
                    <a href="team2012.php">2012</a>
                </div>
                <div class="team-year-nav">
                    <a href="team2010.php">2010</a>
                </div>
                <div class="team-year-nav">
                    <a href="team2009.php">2009</a>
                </div>
            </div>
            <div class="col-sm-10" id="main-content">
                <div class="col-xs-12" id="team-info">
                    <div class="col-xs-12" data-bind="template: {
                         name: 'Templates/Team.tmpl',
                         foreach: Teams,
                         as: 'Team' }">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var TeamViewModel = {
            Teams: ko.observableArray()
        }

        $.ajax({
            url: 'Team/Team.json',
        }).success(function (response) {
            JSON.parse(response).find(function (item) {
                return item.Year == "2015";
            }).Teams.forEach(function (member) {
                TeamViewModel.Teams.push(member);
            });
        });

        ko.applyBindings(TeamViewModel);

    </script>


    <?php include('footer.php') ?>

</div>
