<template>
    <div class="container">
        <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                <h3 class="card-title">All quiz</h3>
                <div class="float-right">
                    <button @click.prevent="addQuestion" data-toggle="modal" class="btn btn-success">
                        Add question
                        <i class="fas fa-question"></i>
                    </button>
                </div>
                <div class="float-right mr-3">
                    <button @click.prevent="addQuizOption" data-toggle="modal" class="btn btn-success">
                        Add quiz option
                        <i class="fas fa-question"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>Show <select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option></select> entries</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <label>
                                    Search:
                                    <input type="search" v-model="search" @keyup.enter="searchIt" class="form-control form-control-sm" placeholder="" aria-controls="example1">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">ID</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Quiz question</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Option one</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Option two</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Option three</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Option four</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Answer</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="even" v-for="quiz in quizes.data" :key="quiz.id">
                                    <td class="sorting_1" tabindex="0">{{quiz.id}}</td>
                                    <td>{{quiz.quiz_question}}</td>
                                    <template v-for="option in quiz.quiz_option">
                                        <td v-if="option.option">{{option.option}}</td>
                                    </template>
                                    <template v-if="quiz.quiz_option.length < 4">
                                        <td v-for="noOption in (4 - quiz.quiz_option.length)">{{'-'}}</td>
                                    </template>
                                    <td v-if="quiz.quiz_option.length">{{quiz.quiz_option[0].answer}}</td>
                                    <td v-else>{{'-'}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editQuiz(quiz.id)">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        /
                                        <a href="#" @click.preven="deleteQuiz(quiz.id)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <pagination :data="quizes" @pagination-change-page="getAllQuiz">
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "QuizList",
        data(){
            return{
                quizes: {},
                search: '',
            }
        },
        created(){
            this.getAllQuiz();
        },
        methods:{
            addQuestion(){
                window.location.replace('/add-quiz-question');
            },
            addQuizOption(){
                window.location.replace('/add-quiz');
            },
            searchIt(){
                console.log('search');
            },
            editQuiz(id){
                console.log(id, 'edit');
            },
            deleteQuiz(id){
                console.log(id, 'delete');
            },
            getAllQuiz(page = 0){
                this.axios.get('/quiz?page=' + page)
                    .then(response => {
                        this.quizes = response.data;
                    }).catch((error) => {

                });
            }
        }
    }
</script>
