@extends('layout')

@section('content')

<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{ $url->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>ID</td>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{ $url->created_at }}</td>
                </tr>
                <tr>
                    <td>Дата обновления</td>
                    <td>{{ $url->updated_at }}</td>
                </tr>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Проверки</h2>
        <form method="post" action="/urls/test">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>
                    <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th>ID</th>
                    <th>Код ответа</th>
                    <th>h1</th>
                    <th>keywords</th>
                    <th>description</th>
                    <th>Дата создания</th>
                </tr>
                                    <tr>
                        <td>701</td>
                        <td>200</td>
                        <td>
        G...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-29 08:49:01</td>
                    </tr>
                                    <tr>
                        <td>700</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-29 08:48:53</td>
                    </tr>
                                    <tr>
                        <td>699</td>
                        <td>200</td>
                        <td>Over 73 mi...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-29 08:48:45</td>
                    </tr>
                                    <tr>
                        <td>698</td>
                        <td>200</td>
                        <td>
        G...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-29 08:48:41</td>
                    </tr>
                                    <tr>
                        <td>697</td>
                        <td>200</td>
                        <td>Over 73 mi...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-28 17:49:34</td>
                    </tr>
                                    <tr>
                        <td>610</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-18 12:46:27</td>
                    </tr>
                                    <tr>
                        <td>605</td>
                        <td>200</td>
                        <td>Over 73 mi...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-08-16 14:39:26</td>
                    </tr>
                                    <tr>
                        <td>355</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-30 09:06:38</td>
                    </tr>
                                    <tr>
                        <td>354</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-30 08:56:43</td>
                    </tr>
                                    <tr>
                        <td>353</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-30 08:56:40</td>
                    </tr>
                                    <tr>
                        <td>352</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-30 08:56:33</td>
                    </tr>
                                    <tr>
                        <td>300</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-21 15:21:56</td>
                    </tr>
                                    <tr>
                        <td>250</td>
                        <td>200</td>
                        <td>You bring...</td>
                        <td></td>
                        <td>You bring the passion, we brin...</td>
                        <td>2021-04-12 13:08:39</td>
                    </tr>
                            </table>
    </div>
</main>
@endsection