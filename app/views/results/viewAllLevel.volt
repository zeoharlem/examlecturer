{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
<div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Total Results For {{results[0]['matric']}}
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ddd;">Course Title</th>
                                    <th style="border:1px solid #ddd;">Code</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Level</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Units</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Points</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Grade Points</th>
                                    <th style="border:1px solid #ddd;" class="text-center">Total Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys, values in results %}
                                <tr>
                                    <td style="border:1px solid #ddd;">{{keys + 1}}</td>
                                    <td style="border:1px solid #ddd;">{{values['title'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values['code'] | upper}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['level']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['units']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['gradePoint']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['gradePoint']*values['units']}}</td>
                                    <td style="border:1px solid #ddd;" class="text-center">{{values['totalScore']}}</td>
                                </tr>
                                {% endfor %}
                                <tr>
                                    <td></td>
                                    <td>Total Units</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnits}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Unit Passed</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnitP}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Unit Failed</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnitF}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>TotalGrade Point</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalGrade}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>Weighted Grade Point</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{weightedGr}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
{% endblock %} 