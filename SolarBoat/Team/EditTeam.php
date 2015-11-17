<?php include('../head.php') ?>

<div style="margin-top:100px; margin-left: 100px">

    <h2>Edit Solar Boat Team:</h2>
    <br />
    <select id="year-drop-down" style="min-width:250px" onchange="hideAllContainers()"
            data-bind="options: Years,
            value: Year,
            optionsText: 'Year',
            optionsCaption: 'Select Year...'">
    </select>
    
    <a data-bind="visible: !Year()" href="javascript:void(0)" onclick="showAddContainer('year')"> + </a><div id="add-year-container" style="display: none"><input id="new-year-textbox" type="text" /> <input type="button" value="Add" onclick="addYear()" /></div>
    <a data-bind="visible: Year" href="javascript:void(0)" onclick="showRemoveContainer('year')"> - </a><div id="remove-year-container" style="display: none"> Are you sure? <input type="button" value="Yes" onclick="removeYear()" /> <input type="button" value="No" onclick="hideRemoveContainer('year')" /></div>

    <br />
    <select id="team-drop-down" style="min-width:250px" onchange="hideAllContainers()"
            data-bind="options: Teams,
            value: Team,
            optionsText: 'TeamName',
            optionsCaption: 'Select Team...',
            enable: Year">
    </select>

    <a data-bind="visible: Year() && !Team()" href="javascript:void(0)" onclick="showAddContainer('team')"> + </a><div id="add-team-container" style="display: none"><input id="new-team-textbox" type="text" /> <input type="button" value="Add" onclick="addTeam()" /></div>
    <a data-bind="visible: Team" href="javascript:void(0)" onclick="showRemoveContainer('team')"> - </a><div id="remove-team-container" style="display: none"> Are you sure? <input type="button" value="Yes" onclick="removeTeam()" /> <input type="button" value="No" onclick="hideRemoveContainer('team')" /></div>

    <br />
    <select id="member-drop-down" style="min-width:250px" onchange="hideAllContainers()"
            data-bind="
            options: Members,
            value: Member,
            optionsText: function(member) { return 'Name: ' + member.Name + ', Role: ' + member.Role },
            optionsCaption: 'Select Member...',
            enable: Team">
    </select>

    <a data-bind="visible: Team() && !Member()" href="javascript:void(0)" onclick="showAddContainer('member')"> + </a>
    <div id="add-member-container" style="display: none">
        Name: <input id="new-member-name-textbox" type="text" /><br />
        Role: <input id="new-member-role-textbox" type="text" /><br />
        Member Photo: <strong>(Must be a 150px by 150px PNG File)</strong><input id="member-photo" type="file" name="member-photo" /><br />
        <input type="button" value="Add" onclick="addMember()" />
    </div>
    <a data-bind="visible: Member" href="javascript:void(0)" onclick="showRemoveContainer('member')"> - </a><div id="remove-member-container" style="display: none"> Are you sure? <input type="button" value="Yes" onclick="removeMember()" /> <input type="button" value="No" onclick="hideRemoveContainer('member')" /></div>
    
</div>

<script>

    var TeamViewModel = {

        Years: ko.observableArray(),
        Year: ko.observable(),
        Team: ko.observable(),
        Member: ko.observable()
    }

    TeamViewModel.Teams = ko.computed(function () {
        return TeamViewModel.Year() && TeamViewModel.Year().Teams ? TeamViewModel.Year().Teams : [];
    });
    TeamViewModel.Members = ko.computed(function () {
        return TeamViewModel.Team() && TeamViewModel.Team().Members ? TeamViewModel.Team().Members : [];
    });


    $.getJSON("Team.json")
    .done(function (response) {
        response.forEach(function(year) {
            TeamViewModel.Years.push(year);
        })
        ko.applyBindings(TeamViewModel);
    });

    function addYear() {
        TeamViewModel.Years.push({
            Year: $("#new-year-textbox").val()
        });
        showRemoveContainer('year');
        saveTeam();
    }

    function removeYear() {
        TeamViewModel.Years.remove(function(year) {
            return TeamViewModel.Year().Year == year.Year;
        });
        hideRemoveContainer('year');
        saveTeam();
    }

    function addTeam() {
        TeamViewModel.Year().Teams.push({
            TeamName: $("#new-team-textbox").val(),
            Members: []
        });
        TeamViewModel.Year.valueHasMutated();
        hideAddContainer('team');
        saveTeam();
    }

    function removeTeam() {
        var index = TeamViewModel.Teams().indexOf(TeamViewModel.Team());
        TeamViewModel.Teams().splice(index, 1);
        TeamViewModel.Year.valueHasMutated();
        hideRemoveContainer('team');
        saveTeam();
    }

    function addMember() {
        TeamViewModel.Team().Members.push({
            Name: $("#new-member-name-textbox").val(),
            Role: $("#new-member-role-textbox").val(),
        });

        TeamViewModel.Team.valueHasMutated();

        var formData = new FormData();
        formData.append("memberphoto", $('#member-photo')[0].files[0]);
        formData.append("filename", $("#new-member-name-textbox").val() + ".jpg");
        $.ajax({
            url: 'saveImage.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
        hideAddContainer('member');
        saveTeam();
    }

    function removeMember() {
        var index = TeamViewModel.Members().indexOf(TeamViewModel.Member());
        TeamViewModel.Members().splice(index, 1);
        TeamViewModel.Team.valueHasMutated();
        hideRemoveContainer('member');
        saveTeam();
    }

    function hideAllContainers() {
        hideRemoveContainer('year');
        hideAddContainer('year');
        hideRemoveContainer('team');
        hideAddContainer('team');
        hideRemoveContainer('member');
        hideAddContainer('member');
    }

    function showAddContainer(type) {
        $("#add-" + type + "-container").css("display", "block");
    }

    function hideAddContainer(type) {
        $("#add-" + type + "-container").css("display", "none");
    }

    function showRemoveContainer(type) {
        $("#remove-" + type + "-container").css("display", "block");
    }

    function hideRemoveContainer(type) {
        $("#remove-" + type + "-container").css("display", "none");
    }

    function saveTeam() {
        $.ajax({
            url: 'SaveTeam.php',
            type: 'POST',
            data: {
                Years: JSON.stringify(TeamViewModel.Years())
            }
        });
    }

</script>

