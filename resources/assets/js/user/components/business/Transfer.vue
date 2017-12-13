<template>
    <div>
        <div class="gm-breadcrumb">
            <!--<i class="ion-ios-home gm-home"></i>-->
            <!-- <el-button type="text" class="gm-back" @click="$router.go(-1)"><i class="el-icon-arrow-left"></i></el-button> -->
            <el-breadcrumb separator="/">
                <el-breadcrumb-item to="/business/deopsit">综合业务</el-breadcrumb-item>
                <el-breadcrumb-item to="/business/deopsit">存钱</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-row>
            <el-col :span="24">
                <el-form> 
                    <el-form-item label="请选择卡号">
                         <CodeNum @change="onCodeNumChange"></CodeNum>
                    </el-form-item>
                    <el-form-item label="请输入对方卡号">
                          <el-input v-model="money" placeholder="请输入对方卡号" style="width:200px" type="number"></el-input>
                    </el-form-item>
                    <el-form-item label="请输入转款金额">
                          <el-input v-model="money" placeholder="请输入转款金额" style="width:200px" type="number"></el-input>
                    </el-form-item>
                    <el-form-item label="请输入密码">
                         <el-input v-model="password" placeholder="请输入密码" type="password" style="width:200px"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmitClick" :loading="isSubmiting">提 交</el-button>
                        <el-button @click="onCancelClick" :loading="isSubmiting">取 消</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script scoped>
import CodeNum from '../widget/CodeNum.vue'
    export default {
        components: {
           CodeNum,
        },
        data() {
            return {
                codeId:0,
                password:null,
                money:0,
                isSubmiting:false
            }
        },
        methods: {
            onCodeNumChange:function(value){
                if(value){
                    this.codeId = value.id
                }
            },
            onCancelClick : function(){
                this.$router.go(-1);
            },
            onSubmitClick : function(){
                this.isSubmiting = true
            }
        },
        mounted() {
        },
    }
</script>