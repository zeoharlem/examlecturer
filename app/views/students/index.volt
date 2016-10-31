{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Students List | <strong>Registered Students</strong>
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <form method="post">
                        <table id="student-datatable" class="display table table-bordered table-striped dataTable">
                            <thead>
                                <th>RID</th>
                                <th>Students</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>M(s)</th>
                                <th>L(s)</th>
                                <th>Department</th>
                                <th>Session(s)</th>
                                <th>Action(s)</th>
                            </thead>
                            <tfoot>
                                <th>#</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><button type="button" id="resultsubmit" class="btn btn-success btn-sm"><strong>Upload</strong></button>
                                <button type="reset" class="btn btn-danger btn-sm"><strong>Reset</strong></button></th>
                            </tfoot>

                        </table>
                        </form>
                    </div>
                    </div>
                </section>
            </div>
{% endblock %}