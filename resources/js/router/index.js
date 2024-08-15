import { createRouter, createWebHistory } from 'vue-router';
import PostersList from '../components/PostersList.vue';
import PosterDetail from '../components/PosterDetail.vue';
import CreatePoster from '../components/CreatePoster.vue';

const routes = [
    { path: '/', component: PostersList },
    { path: '/create', component: CreatePoster },
    { path: '/posters/:id', name: 'poster-detail', component: PosterDetail, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
