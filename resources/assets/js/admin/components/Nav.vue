<template>
    <div>
        <div class="menu_nav_left">
            <el-menu default-active="1" class="el-menu-vertical-demo"
                     @select="click_menu" :collapse="isCollapse">
                <el-menu-item index="0">
                    <i class="el-icon-menu menu_icon"></i>
                    <span slot="title">{{ isCollapse ? '显示菜单' : '隐藏菜单' }}</span>
                </el-menu-item>
                <el-menu-item index="1">
                    <i class="ion-person menu_icon"></i>
                    <span slot="title">用户管理</span>
                </el-menu-item>
                <el-menu-item index="2">
                    <i class="ion-card menu_icon"></i>
                    <span slot="title">账户管理</span>
                </el-menu-item>
                <el-menu-item index="3">
                    <i class="ion-android-clipboard menu_icon"></i>
                    <span slot="title">交易记录</span>
                </el-menu-item>
                <!--<el-submenu index="1">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-person menu_icon"></i>-->
                        <!--<span slot="title">用户管理</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="1-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="1-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <!--<el-submenu index="2">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-ios-gear menu_icon"></i>-->
                        <!--<span slot="title">我的</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="2-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="2-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <!--<el-submenu index="3">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-ios-gear menu_icon"></i>-->
                        <!--<span slot="title">我的</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="3-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="3-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <el-submenu index="4">
                    <template slot="title">
                        <i class="ion-ios-gear menu_icon"></i>
                        <span slot="title">我的</span>
                    </template>
                    <el-menu-item-group>
                        <el-menu-item index="4-1">个人中心</el-menu-item>
                        <el-menu-item index="4-2">注销登录</el-menu-item>
                    </el-menu-item-group>
                </el-submenu>
            </el-menu>
        </div>
        <router-view></router-view>
    </div>
</template>

<style scoped>
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        width: 200px;
        min-height: 400px;
    }

    .menu_icon {
        font-size: 20px;
        margin-right: 10px;
    }
    .menu_nav_left{
        float: left;
    }
</style>

<script scoped>

    export default {
        data() {
            return {
                isCollapse: true
            }
        },
        components: {},
        computed: {},
        methods: {
            handleOpen(key, keyPath) {
                console.log(key)
                $('.el-table').css('width','80% !important');
            },
            handleClose(key, keyPath) {
                $('.el-table').css('width','90% !important');
            },
            click_menu(index) {
                if (index == 0) {
                    this.isCollapse = !this.isCollapse;
                }
            }
        },
        mounted() {
        },
    }
</script>