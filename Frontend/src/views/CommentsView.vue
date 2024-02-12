<script setup lang="ts">

import HomeView from "@/views/HomeView.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import IconComments from "@/components/icons/IconComments.vue";
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import IconShare from "@/components/icons/IconShare.vue";
import IconDots from "@/components/icons/IconDots.vue";
</script>

<template>
    <div class="bg-red-700">

        <div class="relative w-[1200px] mt-7 mx-auto py-2 bg-green-600 ">
            <div class="fixed top-12 left-0 w-full  bg-blue-500 ">
                <div class="flex gap-2 text-white">
                    <p>|</p>
                    <div class="min-w-6 cursor-pointer">
                        <arrow-up-icon />
                    </div>
                    <p class="">3.3k</p>
                    <div class="min-w-6 cursor-pointer">
                        <arrow-down-icon />
                    </div>
                    <p>|</p>
                    <p class="truncate">TVP odmawia ujawnienia infwnienia infwnienia infwnienia infwnienia infwnienia infwnienia infwnienia informwnienia informwnienia informwnienia informwnienia informacji o zarobkach nowych prezenterów</p>
                </div>
            </div>
            <div v-for="n in 5" :key="n">
                <div class=" mx-20 flex mt-10">


                <div class="bg-[#161617] rounded-l-md w-10 text-white">
                    <div class="px-2 text-center flex flex-col items-center gap-1 mt-2">
                        <div class="w-5">
                            <ArrowUpIcon/>
                        </div>

                        <p class="text-white">3.3k</p>

                        <div class="w-5">
                            <ArrowDownIcon/>
                        </div>

                    </div>
                </div>
                <div class="bg-[#1a1a1b] rounded-r-md grow flex flex-col *:mx-2">
                    <div class=" text-sm mt-2 flex gap-1">
                        <p class="text-white">r/shitposting</p>
                        <p class="text-gray-400">Posted by u/Comfortable_Rush2528 5 hours ago</p>
                    </div>
                    <div class="text-white text-xl">Mam dosyć</div>
                    <div class="">
                        <p class=" text-white">
                            Mam 26 lat. Magistra na karku. Do wczoraj marzenia. Tyle lat nauki, podczas studiów
                            dodatkowe kursy.
                            Cały czas się rozwijam i douczam. Na samym początku kariery trafiłam na bardzo toksyczne
                            miejsce gdzie
                            każdy starał się zgnoić młodego a druga połowa udawała że nie istnieje. Rzuciłam tą pracę bo
                            nie dawałam
                            rady psychicznie, zaczęły się napady paniki, sraczki i rzyganie na samą myśl o pracy. Potem
                            starałam się
                            dostać pracę wszędzie. Nie tylko w zawodzie. Na biedronki i sklepy mam za wysokie
                            wykształcenie i to
                            jeszcze nie w takim kierunku co by chcieli. Na jakieś pomoce nauczyciela w przedszkolach
                            również (mimo
                            że mam tu doświadczenie) cytat "bo gdzie pani ze swoimi studiami będzie pupy podcierać
                            dzieciom".
                            Składałam CV do prac wszędzie i chyba do każdej firmy w moim mieście. Jedynie gdzie
                            wybrzydzam to praca
                            fizyczna (również ze względów złych pleców) no i seks praca. Jestem wykształconą osobą.
                            Poszerzającą
                            swoją wiedzę a kurwa od 4 miesięcy nie mogę znaleźć pracy. Przerasta mnie to. Nie wiem co
                            mam robić.
                            Chodzenie do firm. Pisanie maili i dzwonienie nawet jak nie szukają nie pomaga. Od kilku
                            miesięcy
                            wszystko co mogło pójść źle idzie źle. Nie wiem co mam dalej robićMam 26 lat. Magistra na karku. Do wczoraj marzenia. Tyle lat nauki, podczas studiów
                            dodatkowe kursy.
                            Cały czas się rozwijam i douczam. Na samym początku kariery trafiłam na bardzo toksyczne
                            miejsce gdzie
                            każdy starał się zgnoić młodego a druga połowa udawała że nie istnieje. Rzuciłam tą pracę bo
                            nie dawałam
                            rady psychicznie, zaczęły się napady paniki, sraczki i rzyganie na samą myśl o pracy. Potem
                            starałam się
                            dostać pracę wszędzie. Nie tylko w zawodzie. Na biedronki i sklepy mam za wysokie
                            wykształcenie i to
                            jeszcze nie w takim kierunku co by chcieli. Na jakieś pomoce nauczyciela w przedszkolach
                            również (mimo
                            że mam tu doświadczenie) cytat "bo gdzie pani ze swoimi studiami będzie pupy podcierać
                            dzieciom".
                            Składałam CV do prac wszędzie i chyba do każdej firmy w moim mieście. Jedynie gdzie
                            wybrzydzam to praca
                            fizyczna (również ze względów złych pleców) no i seks praca. Jestem wykształconą osobą.
                            Poszerzającą
                            swoją wiedzę a kurwa od 4 miesięcy nie mogę znaleźć pracy. Przerasta mnie to. Nie wiem co
                            mam robić.
                            Chodzenie do firm. Pisanie maili i dzwonienie nawet jak nie szukają nie pomaga. Od kilku
                            miesięcy
                            wszystko co mogło pójść źle idzie źle. Nie wiem co mam dalej robićMam 26 lat. Magistra na karku. Do wczoraj marzenia. Tyle lat nauki, podczas studiów
                            dodatkowe kursy.
                            Cały czas się rozwijam i douczam. Na samym początku kariery trafiłam na bardzo toksyczne
                            miejsce gdzie
                            każdy starał się zgnoić młodego a druga połowa udawała że nie istnieje. Rzuciłam tą pracę bo
                            nie dawałam
                            rady psychicznie, zaczęły się napady paniki, sraczki i rzyganie na samą myśl o pracy. Potem
                            starałam się
                            dostać pracę wszędzie. Nie tylko w zawodzie. Na biedronki i sklepy mam za wysokie
                            wykształcenie i to
                            jeszcze nie w takim kierunku co by chcieli. Na jakieś pomoce nauczyciela w przedszkolach
                            również (mimo
                            że mam tu doświadczenie) cytat "bo gdzie pani ze swoimi studiami będzie pupy podcierać
                            dzieciom".
                            Składałam CV do prac wszędzie i chyba do każdej firmy w moim mieście. Jedynie gdzie
                            wybrzydzam to praca
                            fizyczna (również ze względów złych pleców) no i seks praca. Jestem wykształconą osobą.
                            Poszerzającą
                            swoją wiedzę a kurwa od 4 miesięcy nie mogę znaleźć pracy. Przerasta mnie to. Nie wiem co
                            mam robić.

                        </p>
                    </div>
                    <div class="flex justify-start gap-1 text-gray-400 py-1 text-sm">
                        <div class="hover:bg-[#2d2d2e] rounded-sm p-1 cursor-pointer flex items-center gap-1">
                            <IconComments/>
                            188 Comments
                        </div>
                        <div class="hover:bg-[#2d2d2e] rounded-sm p-1 cursor-pointer flex items-center gap-1">
                            <IconShare/>
                            Share
                        </div>
                        <div class="hover:bg-[#2d2d2e] rounded-sm p-1 cursor-pointer flex items-center gap-1">
                            <IconBookmark/>
                            Save
                        </div>
                        <div class="hover:bg-[#2d2d2e] rounded-sm p-1 cursor-pointer flex items-center">
                            <IconDots/>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
</template>

<style scoped>

</style>