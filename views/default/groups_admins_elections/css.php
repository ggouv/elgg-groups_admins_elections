.mandat .elgg-heading-basic {
	background-color: #F4F4F4;
	border-radius: 4px;
}
.mandat-group-profile {
	color: #999999;
	cursor: default;
	font-size: 85%;
	font-style: italic;
	line-height: 1.3em;
}
.mandats .mandat-group-profile.date {
	line-height: 6px;
	vertical-align: top;
}
/* hack Chrome / Safari */
@media screen and (-webkit-min-device-pixel-ratio:0) {
	.mandats .elgg-river-timestamp.date {
		line-height: 12px;
	}
}
.election-overdue {
	color: red;
}
.elgg-form-elections-edit-mandat .elgg-user-picker > label, .elgg-form-elections-edit-mandat .elgg-user-picker > input[type=checkbox] { /* ugly hack, need to enhance userpicker */
	display: none;
}