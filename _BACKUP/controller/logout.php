<?php

/**
 * Logout current user by removing session
 * variables then redirecting to login page
 */
sessionRemoveVar('loggedIn');
sessionRemoveVar('userId');
sessionRemoveVar('currentPropertyId');
sessionRemoveVar('currentDivisionId');
sessionRemoveVar('currentDepartmentId');
jumpToPage('login');
