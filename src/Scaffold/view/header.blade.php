
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <span class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle</span>
                <span class="icon-bar"></span>
            </span>
            <span class="navbar-brand">Entity</span>
        </div>
        <div class="collapse navbar-collapse">
            <div>
                <ul class="nav navbar-nav">
                    <li v-bind:class="{active: 'file' == tab}">
                        <a v-on:click="show('file')" href="javascript:void(0);">File</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li v-bind:class="{active: 'project' == tab}">
                        <a v-on:click="show('project')" href="javascript:void(0);">Project</a></li>
                    <li v-bind:class="{active: 'table' == tab}">
                        <a v-on:click="show('table')" href="javascript:void(0);">Table</a></li>
                    <li v-bind:class="{active: 'seed' == tab}">
                        <a v-on:click="show('seed')" href="javascript:void(0);">Seed</a></li>
                    <li v-bind:class="{active: 'model' == tab}">
                        <a v-on:click="show('model')" href="javascript:void(0);">Model</a></li>
                    <li v-bind:class="{active: 'controller' == tab}">
                        <a v-on:click="show('controller')" href="javascript:void(0);">Controller</a></li>
                    <li v-bind:class="{active: 'form' == tab}">
                        <a v-on:click="show('form')" href="javascript:void(0);">Form</a></li>
                </ul>
            </div>
        </div><!-- /.nav-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->

<div style="margin-top:55px"></div>
