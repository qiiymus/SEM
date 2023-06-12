<Style>
    @blue: #626E7E;
@light: lighten(@blue, 40%);
@light2: darken(@light, 3%);

table{
  font-family:sans-serif;
		  width: 100%;
		  border-spacing: 0;
	  	border-collapse: separate;
		  table-layout: fixed;
		  margin-bottom: 50px;

		  thead{
			    tr{
				      th{
        					background: @blue;
					        color: @light;
					        padding: 0.5em;
					        overflow: hidden;

        					&:first-child{
						          border-radius:3px 0 0 0;
					        } 
					        &:last-child{
						          border-radius:0 3px  0 0;
					        }

        					.day{
						          display: block;
						          font-size: 1.2em;
						          border-radius: 50%;
					          		width: 30px;
					          	height: 30px;
						          margin: 0 auto 5px;
						          padding: 5px;
          line-height: 1.8;

            						&.active{
							              background: @light;
							              color: @blue;
						            }
					        }

        					.short{
						          display: none;
					        }

        					i{
					          	vertical-align: middle;
						          font-size: 2em;
					        }
				      }
			    }
		  }
		  tbody{
			    tr{
				      background: @light;

      					&:nth-child(odd){
						        background:@light2;
				      	}
					      &:nth-child(4n+0){
						        td{
							          border-bottom:1px solid @blue;
						        }
					      }
				      td{
					        text-align: center;
					        vertical-align: middle;
					        border-left: 1px solid @blue;
					        position: relative;
					        height: 35px;
					        cursor: pointer;

        					&:last-child{
						          border-right:1px solid @blue;
					        }
        &.hour{
						          font-size: 2em;
						          padding: 0;
						          color: @blue;
						          background:#fff;
					          	border-bottom:1px solid @blue;
						          border-collapse: separate;
						          min-width: 100px;
						          cursor: default;

          						span{
							            display: block;

	          					}
					        }  	
				      }
			    }
		  }

  		@media(max-width:60em){

    			thead{
				      tr{
					        th{
						          .long{
							            display: none;
						          }

          						.short{
							            display: block;
						          }

        					}
				      }
			    }

    			tbody{
				      tr{
					        td{
						          &.hour{
							            span{
								              transform:rotate(270deg);
              -webkit-transform:rotate(270deg);
              -moz-transform:rotate(270deg);
							            }
						          }
        		}
				      }
			    }
		  }

	  	@media(max-width:27em){
    			thead{
				      tr{
					        th{
						          font-size: 65%;
						          .day{
							            display: block;
							            font-size: 1.2em;
							            border-radius: 50%;
							            			width: 20px;
							            height: 20px;
							            margin: 0 auto 5px;
							            padding: 5px;

            							&.active{
							              	background: @light;
								              color: @blue;
							            }
						          }
					        }
				      }
			    }
			    tbody{
				      tr{
					        td{
						          &.hour{
							            font-size: 1.7em;
							            span{
							              transform:translateY(16px)rotate(270deg);
              -webkit-transform:translateY(16px)rotate(270deg);
              -moz-transform:translateY(16px)rotate(270deg);
							            }
						          }
        	}
				      }
			    }
		  }
	}
</Style>
<x-app-layout>
    <div class="h-full">
        <p class="text-xl mb-4">Duty Roster</p>
        <div class="flex justify-end w-full mb-5 relative right-0">
            @include('components.searchbar')
            <a href="{{ route('addDuty') }}" 
                class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Add Duty
            </a>
        </div>
        {{-- <div class="bg-white border border-slate-300 rounded-xl w-full p-4 overflow-y-auto h-4/5">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th class="py-2">User ID</th>
                        <th class="py-2">User Name</th>
                        <th class="py-2">Week</th>
                        <th class="py-2">Date</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Start Time</th>
                        <th class="py-2">End Time</th>
                        <th class="py-2">Created At</th>
                        <th class="py-2">Updated At</th>
                        <th class="py-2">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($dutyRoster as $item)
                        <tr class="bg-gray-200 border-y-8 border-white">
                            <td class="py-2">{{ $item->user_id }}</td>
                            <td class="py-2">{{ $item->user_name }}</td>
                            <td class="py-2">{{ $item->week }}</td>
                            <td class="py-2">{{ $item->date }}</td>
                            <td class="py-2">{{ $item->status }}</td>
                            <td class="py-2">{{ $item->start_time }}</td>
                            <td class="py-2">{{ $item->end_time }}</td>
                            <td class="py-2">{{ $item->created_at }}</td>
                            <td class="py-2">{{ $item->updated_at }}</td>
                            <td class="flex justify-center">
                                <a href="{{ route('editDuty', $item->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 m-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <script>
                                    function confirmDeleteDuty() {
                                        return confirm('Are you sure you want to delete the Duty?');
                                    }
                                </script> 
                                <form action="{{ route('deleteDuty', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" onclick="return confirmDeleteDuty()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400 m-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form> 
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

{{-- <table>
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dutyRoster as $event)
            <tr>
                <td>{{ $event->event_name }}</td>
                <td>{{ $event->start_time }} - {{ $event->end_time }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
@foreach ($dutyRoster as $event)
<tr class="{{ ($event->start_time == $start_time && $event->end_time == $endHour) ? 'highlighted-row' : '' }}">
    <td>{{ $event->user_name }}</td>
    <td>{{ $event->start_time }}:00 - {{ $event->end_time }}:00</td>
</tr>
@endforeach
<table>
  <thead>
    <tr>
      <th></th>
      <th>
        <span class="day">1</span>
        <span class="long">Monday</span>
        <span class="short">Mon</span>
      </th>
      <th>
        <span class="day">2</span>
        <span class="long">Tuesday</span>
        <span class="short">Tue</span>
      </th>
      <th>
        <span class="day">3</span>
        <span class="long">Wendsday</span>
        <span class="short">We</span>
      </th>
      <th>
        <span class="day">4</span>
        <span class="long">Thursday</span>
        <span class="short">Thur</span>
      </th>
      <th>
        <span class="day active">5</span>
        <span class="long">Friday</span>
        <span class="short">Fri</span>
      </th>
      <th>
        <span class="day">6</span>
        <span class="long">Saturday</span>
        <span class="short">Sat</span>
      </th>
      <th>
        <span class="day">7</span>
        <span class="long">Sunday</span>
        <span class="short">Sun</span>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="hour" rowspan="4"><span>1:00</span></td>
     
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>2:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    
    <tr>
      <td class="hour" rowspan="4"><span>3:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>4:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>5:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>6:00</span></td>
      <td onclick="alert('test')"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>7:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="hour" rowspan="4"><span>8:00</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
    </div>
</x-app-layout>
