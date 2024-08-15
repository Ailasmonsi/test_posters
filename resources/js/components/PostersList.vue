<template>
    <div class="posters">
        <h2 class="posters__title">Список объявлений</h2>
        <div class="posters__sort">
            <div class="sort_by">
                <label for="sortBy">Сортировать по:</label>
                <select id="sortBy" v-model="sortBy" @change="fetchPosters(true)">
                    <option value="price">Цене</option>
                    <option value="created_at">Дате создания</option>
                </select>
            </div>
            <div class="order_by">
                <label for="order">Порядок:</label>
                <select id="order" v-model="order" @change="fetchPosters(true)">
                    <option value="asc">По возрастанию</option>
                    <option value="desc">По убыванию</option>
                </select>
            </div>
        </div>

        <div class="posters__list">
            <div class="posters__list_item" v-for="poster in posters" :key="poster.id">
                <h3>{{ poster.title }}</h3>
                <img :src="poster.main_photo" alt="Main Photo" class="poster-image"/>
                <p>Цена: {{ poster.price }} ₽</p>
                <router-link :to="{ name: 'poster-detail', params: { id: poster.id } }" class="button">Подробнее
                </router-link>
            </div>
        </div>

        <button @click="fetchPosters()" :disabled="loading" class="load-more-button">
            {{ loading ? 'Загрузка...' : 'Загрузить ещё' }}
        </button>
    </div>
</template>

<script>
import {onMounted, ref} from 'vue';
import axios from 'axios';

export default {
    setup() {
        const posters = ref([]);
        const page = ref(1);
        const sortBy = ref('price');
        const order = ref('asc');
        const loading = ref(false);

        const fetchPosters = (reset = false) => {
            if (reset) {
                posters.value = [];
                page.value = 1;
            }
            loading.value = true;

            axios
                .get('/api/posters', {
                    params: {
                        page: page.value,
                        sort_by: sortBy.value,
                        order: order.value,
                    },
                })
                .then((response) => {
                    posters.value = posters.value.concat(response.data.data);
                    page.value++;
                })
                .catch((error) => {
                    console.error('Не удалось загрузить объявления:', error);
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        onMounted(() => {
            fetchPosters();
        });

        return {
            posters,
            fetchPosters,
            sortBy,
            order,
            loading,
        };
    },
};
</script>

<style scoped>
.posters {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.posters__title {
    margin-bottom: 36px;
}

.posters__sort {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    gap: 16px;
}

label {
    margin-right: 10px;
    font-weight: bold;
}

select {
    padding: 4px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.posters__list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.posters__list_item {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Позволяет кнопке быть внизу карточки */
    //height: 100%; /* Карточки будут одинаковой высоты */
}

.poster-image {
    width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 10px;
    flex: 1 1 auto; /* Позволяет изображению занять оставшееся пространство */
}

.button {
    display: inline-block;
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: auto; /* Подталкивает кнопку вниз */
}


.button:hover {
    background-color: #0056b3;
}

.load-more-button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.load-more-button:hover {
    background-color: #0056b3;
}
</style>
