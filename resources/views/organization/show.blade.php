@extends('master')

@section('body')
    <h2 class="text-center mt-3 mb-3">{{ $organization['name'] }}</h2>

    <div class="row mb-4">
        <div class="col col-12 col-md-6">
            <select class="form-select" id="select-problem">
                <option selected value="all">Tất cả bài tập</option>
                @foreach ($problems as $problem)
                    <option value="{{ $problem['code'] }}" 
                        {{ $problem['code'] == $problemSlug ? 'selected' : '' }}
                    >{{ $problem['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                @if (!isset($problemSlug))
                    <th scope="col" class="text-center">Tổng lần nộp</th>
                    <th scope="col" class="text-center">Tổng bài nộp</th>
                    <th scope="col" class="text-center">Bài đã AC</th>
                @endif
            </tr>
        </thead>
        <tbody class="table-group-divider">
            
                @foreach ($users as $index => $user)
                    <tr>
                        <td scope="row">{{ $index + 1 }}</td>
                        <td>
                            <b style="color: #545454">{{ $user['user']['first_name'] }}</b> <br>
                            <small style="color: #999797">{{ $user['user']['username'] }}</small>
                        </td>
                        @if (!isset($problemSlug))
                            <td class="text-center">123</td>
                            <td class="text-center">123</td>
                            <td class="text-center">123</td>
                        @endif
                    </tr>
                @endforeach
           
        </tbody>
    </table>

    <script>
        setTimeout(() => {
            location.reload();
        }, 30000);

        document.getElementById('select-problem').addEventListener('change', (event) => {
            const problemId = event.target.value;
            if (problemId === 'all') {
                window.location.href = `{{ route('organization.show', ['organizationSlug' => $organization['slug']]) }}`;
            } else {
                window.location.href = `{{ route('organization.show', ['organizationSlug' => $organization['slug']]) }}?problem=${problemId}`;
            }
        });
    </script>
@endsection