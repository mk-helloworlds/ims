@php use App\Http\Controllers\MyUtility; use Illuminate\Support\Facades\Auth; @endphp

<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">

                    <li class="nav-item">
                        <a>
                            <span >USER TYPE : {{strtoupper(Auth::user()->role->role_name)}}</span>
                        </a>
                    </li>

                    <li class="nav-item submenu {{ (request()->is('*dashboard*')) ? 'active' : '' }} ">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span >DASHBOARD</span>
                            <span class="caret"></span>
                        </a>
                    </li>

                    <!-- <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">{{__("messages.system_preference")}}</h4>
                    </li> -->

                    <!-- <li class="nav-item submenu {{request()->is('*preference/user_role*') ? 'active' : '' }}">
                        <a href="{{route('user_role.index')}}">
                            <i class="fa fa-id-badge"></i>
                            <span>
                            FEATURES
                            </span>
                            <span></span>
                        </a>
                    </li>

                    <li class="nav-item submenu {{request()->is('*preference/user_role*') ? 'active' : '' }}">
                        <a href="{{route('user_role.index')}}">
                            <i class="fa fa-id-badge"></i>
                            <span>
                            FEATURES
                            </span>
                            <span></span>
                        </a>
                    </li> -->

                    <!-- ADMIN : ALL FEATURES -->
                    @if(Auth::user()->role->role_name == 'admin')
                    <li class="nav-item submenu {{request()->is('*preference*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#submenu2">
                            <i class="fa fa-id-badge"></i>
                            <span>
                            ALL FEATURES
                            </span>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse {{ request()->is('*preference*')? 'show' : '' }}" id="submenu2">
                            <ul class="nav nav-collapse">

                                <li class="{{ (request()->is('*/user_role')) ? 'active' : '' }}">
                                    <a href="{{route('user_role.index')}}">
                                        <span class="sub-item">MANAGE USER ROLES</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/user')) ? 'active' : '' }}">
                                    <a href="{{route('user.index')}}">
                                        <span class="sub-item">MANAGE USERS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/category')) ? 'active' : '' }}">
                                    <a href="{{route('category.index')}}">
                                        <span class="sub-item">MANAGE CATEGORIES</span>
                                    </a>
                                </li>


                                <li class="{{ (request()->is('*/company')) ? 'active' : '' }}">
                                    <a href="{{route('company.index')}}">
                                        <span class="sub-item">MANAGE COMPANY</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/internship')) ? 'active' : '' }}">
                                    <a href="{{ route('internship.index') }}">
                                        <span class="sub-item">MANAGE INTERNSHIP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/internship')) ? 'active' : '' }}">
                                    <a href="{{ route('internship.index') }}">
                                        <span class=" sub-item">MANAGE INTERNSHIP PROJECTS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/student_submission_form*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_submission_form.index') }}">
                                        <span class=" sub-item">STUDENT: FORM SUBMISSION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/submission_form*')) ? 'active' : '' }}">
                                    <a href="{{ route('submission_form.index') }}">
                                        <span class="sub-item">MANAGE FORM SUBMISSION</span>
                                    </a>
                                </li>


                                <li class="{{ (request()->is('*follow_up/student_detail*')) ? 'active' : '' }}">
                                    <a href="{{ route('student.follow_up.index', Auth::user()->id) }}">
                                        <span class="sub-item">STUDENT: FOLLOW UP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*advisor_follow_up*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor.follow_up.index') }}">
                                        <span class="sub-item">ADVISOR: FOLLOW UP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/follow_up*')) ? 'active' : '' }}">
                                    <a href="{{ route('follow_up.index') }}">
                                        <span class="sub-item">ADMIN: FOLLOW UP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_thesis_document*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_thesis_document.index') }}">
                                        <span class="sub-item">STUDENT: THESIS DOCUMENT SUBMISSION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*advisor_thesis_document*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor_thesis_document.index') }}">
                                        <span class="sub-item">ADVISOR: THESIS DOCUMENT APPROVAL</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/thesis_document*')) ? 'active' : '' }}">
                                    <a href="{{ route('thesis_document.index') }}">
                                        <span class="sub-item">ADMIN MANAGE: THESIS DOCUMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_defense_request*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_defense_request.index') }}">
                                        <span class="sub-item">STUDENT: DEFENSE REQUEST</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*advisor_defense_request*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor_defense_request.index') }}">
                                        <span class="sub-item">ADVISOR: DEFENSE REQUEST</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*admin_defense_request*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin_defense_request.index') }}">
                                        <span class="sub-item">ADMIN MANAGE: DEFENSE REQUEST</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*jury_group*')) ? 'active' : '' }}">
                                    <a href="{{ route('jury_group.index') }}">
                                        <span class="sub-item">MANAGE JURY GROUP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_enrollment*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_enrollment.index') }}">
                                        <span class="sub-item">ADMIN MANAGE : DEFENSE ENROLLMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_defense_enrollment*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_defense_enrollment.index') }}">
                                        <span class="sub-item">STUDENT : DEFENSE ENROLLMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*jury_defense_enrollment*')) ? 'active' : '' }}">
                                    <a href="{{ route('jury_defense_enrollment.index') }}">
                                        <span class="sub-item">Jury : DEFENSE ENROLLMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*evaluation_question*')) ? 'active' : '' }}">
                                    <a href="{{ route('evaluation_question.index') }}">
                                        <span class="sub-item">EVALUATION QUESTIONS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*jury_evaluation*')) ? 'active' : '' }}">
                                    <a href="{{ route('jury_evaluation.index') }}">
                                        <span class="sub-item">JURY: EVALUATION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/evaluation*')) ? 'active' : '' }}">
                                    <a href="{{ route('evaluation.index') }}">
                                        <span class="sub-item">ADMIN: EVALUATION</span>
                                    </a>
                                </li>

                                <!-- DEFENSE RESULTS -->

                                <li class="{{ (request()->is('*/defense_results')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.index') }}">
                                        <span class="sub-item">ADMIN: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_results/jury*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.jury') }}">
                                        <span class="sub-item">JURY: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_results/student*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.student') }}">
                                        <span class="sub-item">STUDENT: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_results/advisor*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.advisor') }}">
                                        <span class="sub-item">ADVISOR: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- STUDENT : FEARTURES FOR STUDENT-->
                    @if(Auth::user()->role->role_name == 'student')
                    <li class="nav-item submenu {{request()->is('*preference*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#submenu3">
                            <i class="fa fa-id-badge"></i>
                            <span>
                            STUDENT FEATURES
                            </span>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse {{ request()->is('*preference*')? 'show' : '' }}" id="submenu3">
                            <ul class="nav nav-collapse">

                                <li class="{{ (request()->is('*/student_submission_form*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_submission_form.index') }}">
                                        <span class=" sub-item">STUDENT: FORM SUBMISSION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*follow_up/student_detail*')) ? 'active' : '' }}">
                                    <a href="{{ route('student.follow_up.index', Auth::user()->id) }}">
                                        <span class="sub-item">STUDENT: FOLLOW UP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_thesis_document*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_thesis_document.index') }}">
                                        <span class="sub-item">STUDENT: THESIS DOCUMENT SUBMISSION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_defense_request*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_defense_request.index') }}">
                                        <span class="sub-item">STUDENT: DEFENSE REQUEST</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*student_defense_enrollment*')) ? 'active' : '' }}">
                                    <a href="{{ route('student_defense_enrollment.index') }}">
                                        <span class="sub-item">STUDENT : DEFENSE ENROLLMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_results/student*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.student') }}">
                                        <span class="sub-item">STUDENT: DEFENSE RESULTS</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- ADVISOR : FEATURES FOR ADVISOR-->
                    @if(Auth::user()->role->role_name == 'advisor')
                    <li class="nav-item submenu {{request()->is('*preference*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#submenu4">
                            <i class="fa fa-id-badge"></i>
                            <span>
                            ADVISOR FEATURES
                            </span>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse {{ request()->is('*preference*')? 'show' : '' }}" id="submenu4">
                            <ul class="nav nav-collapse">

                                <li class="{{ (request()->is('*advisor_follow_up*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor.follow_up.index') }}">
                                        <span class="sub-item">ADVISOR: FOLLOW UP</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*advisor_thesis_document*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor_thesis_document.index') }}">
                                        <span class="sub-item">ADVISOR: THESIS DOCUMENT APPROVAL</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*advisor_defense_request*')) ? 'active' : '' }}">
                                    <a href="{{ route('advisor_defense_request.index') }}">
                                        <span class="sub-item">ADVISOR: DEFENSE REQUEST</span>
                                    </a>
                                </li>


                                <li class="{{ (request()->is('*/defense_results/advisor*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.advisor') }}">
                                        <span class="sub-item">ADVISOR: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- JURY : FEATURES FOR JURY-->
                    @if(Auth::user()->role->role_name == 'jury')
                    <li class="nav-item submenu {{request()->is('*preference*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#submenu5">
                           <i class="fa fa-bars" aria-hidden="true"></i>
                            <span>
                            JURY FEATURES
                            </span>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse {{ request()->is('*preference*')? 'show' : '' }}" id="submenu5">
                            <ul class="nav nav-collapse">

                                <li class="{{ (request()->is('*jury_defense_enrollment*')) ? 'active' : '' }}">
                                    <a href="{{ route('jury_defense_enrollment.index') }}">
                                        <span class="sub-item">Jury : DEFENSE ENROLLMENT</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*jury_evaluation*')) ? 'active' : '' }}">
                                    <a href="{{ route('jury_evaluation.index') }}">
                                        <span class="sub-item">JURY: EVALUATION</span>
                                    </a>
                                </li>

                                <li class="{{ (request()->is('*/defense_results/jury*')) ? 'active' : '' }}">
                                    <a href="{{ route('defense_results.jury') }}">
                                        <span class="sub-item">JURY: DEFENSE RESULTS</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
