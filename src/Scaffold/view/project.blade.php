<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Entity</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/entity.css">

    <script type="text/javascript" src="/js/es6-promise.auto.min.js"></script>
    <script type="text/javascript" src="/js/axios.min.js"></script>
    <script type="text/javascript" src="/js/vue.js"></script>
    <script type="text/javascript" src="/js/entity.js"></script>
</head>
<body>
<!--[if lt IE 11]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="entity">

    @include('entity::header')

    <div class="container">

        <!-- Project -->
        <div v-show="tab=='project'">
            <h3>
                <span v-text="project.name"></span>
                <span v-on:click="saveProject" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="project" :button="true"></ccc-property>

            <!-- Entry -->
            <ccc-entry :project="project" v-on:show="showEntry"></ccc-entry>
        </div>

        <!-- Migration -->
        <div v-if="entry" v-show="tab=='table'">
            <h3>
                <span v-text="entry.table.name"></span> Table
                <span v-on:click="saveMigration" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.table"></ccc-property>

            <!-- Field -->
            <ccc-field :table="entry.table"></ccc-field>

            <!-- Index -->
            <ccc-index :table="entry.table"></ccc-index>
        </div>

        <!-- Seed -->
        <div v-if="entry && tab=='seed'">
            <h3>
                <span v-text="entry.factory.name"></span>
                <span v-on:click="saveFactory" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.factory"></ccc-property>

            <!-- Factory -->
            <ccc-factory :factory="entry.factory"></ccc-factory>
        </div>

        <!-- Model -->
        <div v-if="entry && tab=='model'">
            <h3>
                <span v-text="entry.model.name"></span> Model
                <span v-on:click="saveModel" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.model"></ccc-property>

            <!-- Relation -->
            <ccc-relation :model="entry.model" :project="project"></ccc-relation>

            <!-- Validation -->
            <ccc-validation :model="entry.model"></ccc-validation>
        </div>

        <!-- Controller -->
        <div v-if="entry && tab=='controller'">
            <h3>
                <span v-text="entry.controller.name"></span>
                <span v-on:click="saveController" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.controller"></ccc-property>

            <!-- Middleware -->
            <ccc-middleware :controller="entry.controller"></ccc-middleware>
        </div>


        <!-- Form -->
        <div v-if="entry && tab=='form'">
            <h3>
                <span v-text="entry.name"></span> Form
                <span v-on:click="saveForm" class="btn btn-success">Save</span>
            </h3>

            <!-- Form -->
            <ccc-form :form="entry.form"></ccc-form>
        </div>

    </div>


    <!-- Choose -->
    <ccc-choose v-show="choose.visible" :data="choose.data" v-on:close="close"></ccc-choose>

</div>
<br>

@include('entity::dialogue')
@include('entity::choose')

@include('entity::property')
@include('entity::entry')
@include('entity::field')
@include('entity::index')
@include('entity::factory')
@include('entity::relation')
@include('entity::validation')
@include('entity::middleware')
@include('entity::form')

<script type="text/javascript">

    function choose(data) {
        vvv.showChoose(data);
    }

    const vm = {};

    vm.show = function (tab) {
        this.tab = tab;
    };

    vm.showChoose = function (data) {
        this.choose.data = data;
        this.choose.visible = true;
    };

    vm.close = function () {
        this.choose.visible = false;
    };

    vm.load = function (data) {
        if (data) {
            this.project.load(data);
        }
    };

    vm.showEntry = function (entry) {
        this.entry = entry;
        this.show('table');
    };

    vm.saveProject = function () {
        let data = {
            project: JSON.stringify(this.project)
        };
        save('/entity', data);
    };

    vm.saveMigration = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/table', data);
    };

    vm.saveModel = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/model', data);
    };

    vm.saveFactory = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/factory', data);
    };

    vm.saveController = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/controller', data);
    };

    vm.saveForm = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/form', data);
    };


    const vvv = new Vue({
        el: '#entity',
        data: {
            tab: 'project',
            choose: {
                visible: false,
                data: {
                    message: '',
                    display: null,
                    array: [],
                    callback: null
                }
            },
            entry: null,
            project: new Project('New Project')
        },
        created: function () {
            this.load(@echo($project))
        },
        methods: vm
    });

</script>

</body>
</html>