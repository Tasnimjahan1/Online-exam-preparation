<template>
    <div class="container">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add quiz question</h3>
            </div>
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3">Question</label>
                        <div class="col-sm-9">
                                    <textarea v-model="form.quiz_question" name="question"
                                              class="form-control d-flex justify-content-center"
                                              placeholder="Enter question title"></textarea>
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
        name: "AddQuizQuestion",
        data(){
            return{
                form: new Form({
                    quiz_question: '',
                })
            }
        },
        methods:{
            addQuiz(){
                this.axios.post('/quiz/question', this.form)
                    .then((response) => {
                        toast.fire({
                            icon: 'success',
                            title: 'User created successfully'
                        });
                        this.form.quiz_question = '';
                    }).catch(()=>{

                });
            }
        }
    }
</script>