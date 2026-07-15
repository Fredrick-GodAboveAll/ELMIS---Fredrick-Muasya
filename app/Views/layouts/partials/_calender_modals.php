        <!-- CALENDER MODALS  -->
        <div class="modal fade" id="eventDetailsModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border"></div>
          </div>
        </div>
        <div class="modal fade" id="addEventModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content border">
              <form id="addEventForm" autocomplete="off">
                <div class="modal-header px-x1 bg-body-tertiary border-bottom-0">
                  <h5 class="modal-title">Create Schedule</h5><button class="btn-close me-n1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-x1">
                  <div class="mb-3"><label class="fs-9" for="eventTitle">Title</label><input class="form-control" id="eventTitle" type="text" name="title" required="required" /></div>
                  <div class="mb-3"><label class="fs-9" for="eventStartDate">Start Date</label><input class="form-control datetimepicker" id="eventStartDate" type="text" required="required" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' /></div>
                  <div class="mb-3"><label class="fs-9" for="eventEndDate">End Date</label><input class="form-control datetimepicker" id="eventEndDate" type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' /></div>
                  <div class="form-check"><input class="form-check-input" type="checkbox" id="eventAllDay" name="allDay" /><label class="form-check-label" for="eventAllDay">All Day</label></div>
                  <div class="mb-3"> <label class="fs-9">Schedule Meeting</label>
                    <div><a class="btn badge-subtle-success btn-sm" href="#!"><span class="fas fa-video me-2"></span>Add video conference link</a></div>
                  </div>
                  <div class="mb-3"><label class="fs-9" for="eventDescription">Description</label><textarea class="form-control" rows="3" name="description" id="eventDescription"></textarea></div>
                  <div class="mb-3"><label class="fs-9" for="eventLabel">Label</label><select class="form-select" id="eventLabel" name="label">
                      <option value="" selected="selected">None</option>
                      <option value="primary">Business</option>
                      <option value="danger">Important</option>
                      <option value="success">Personal</option>
                      <option value="warning">Must Attend</option>
                    </select></div>
                </div>
                <div class="modal-footer d-flex justify-content-end align-items-center bg-body-tertiary border-0"><a class="me-3 text-600" href="../app/events/create-an-event.html">More options</a><button class="btn btn-primary px-4" type="submit">Save</button></div>
              </form>
            </div>
          </div>
        </div>