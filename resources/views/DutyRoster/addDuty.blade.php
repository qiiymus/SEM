<x-app-layout>
    <div class="w-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Add Duty Roster
        </div>
        <div class="bg-white border border-slate-300 rounded-xl w-full p-3">
            <form action="{{ route('storeDuty') }}" method="post">
                @csrf
                <table class="rounded-xl px-4 w-3/6">
                    <tbody>
                        <tr>
                            <td class="px-4 py-2"><label>User Id</label></td>
                            <td class="px-4 py-2"><input type="text" name="user_id" value=""
                                    class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400"></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Week</label></td>
                            <td class="px-4 py-2">
                                <select name="week" class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Date</label></td>
                            <td class="px-4 py-2"><input type="date" name="date" value=""
                                    class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400"
                                    step=".01"></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>Start Time</label></td>
                            <td class="px-4 py-2"><input type="time" name="start_time" value=""
                                    class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400"></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><label>End Time</label></td>
                            <td class="px-4 py-2"><input type="time" name="end_time" value=""
                                    class="form-control rounded-xl w-2/5 bg-gray-200 border border-slate-400"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-end px-4 py-2">
                    <div class="px-4">
                        <a href="{{ route('DutyRoster') }}"><input type="button" value="Cancel"
                                class="btn border border-slate-400 bg-gray-400 px-3 py-2 rounded-xl hover:bg-gray-300"></a>
                    </div>
                    <div class="px-4">
                        <input type="submit" value="Save"
                            class="btn btn-success border border-slate-300 bg-emerald-500/80 px-3 py-2 rounded-xl hover:bg-emerald-400/80">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
