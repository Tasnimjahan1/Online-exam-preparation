<template>
    <div class="container">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add new quiz</h3>
            </div>
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Question</label>
                        <select v-model="form.quiz_id" class="col-sm-9">
                            <option v-for="(question, index) in questionData" v-bind:value="question.id" :key="index" :selected="index === 0 ? 'selected' : ''">
                                {{question.quiz_question}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Option</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="form.option" class="form-control" placeholder="Enter option">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Answer</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="form.answer" class="form-control" placeholder="Enter answer">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer float-right">
                    <button type="submit" class="btn btn-default mr-2">Cancel</button>
                    <button type="submit" class="btn btn-info" @click.prevent="addQuiz">Save</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddQuiz",
        data(){
            return{
                questionData: {},
                form: new Form({
                    quiz_id: '',
                    option: '',
                    answer: ''
                })
            }
        },
        mounted(){
            this.getQuestion();
        },
        methods:{
            getQuestion(){
                this.axios.get('/get-question')
                    .then((response) => {
                        this.questionData = response.data;
                    }).catch(()=>{

                });
            },
            addQuiz(){
                this.axios.post('/quiz', this.form)
                    .then((response) => {
                        this.form = {};
                        toast.fire({
                            icon: 'success',
                            title: 'User created successfully'
                        });
                    }).catch(()=>{

                });
            }
        }
    }
</script>
