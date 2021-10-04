<?php

namespace App\Enums;

abstract class eRespCode
{
  // Common
  const _403_NOT_AUTHORIZED = ['403_00' => 'Not Authorized'];
  const _400_BAD_REQUEST = ['400_00' => 'Bad Request'];
  const _500_INTERNAL_ERROR = ['500_00' => 'Internal Error'];
  const _520_UNKNOWN_ERROR = ['520_00' => 'Unknown Error'];
  const _200_OK = ['200_00' => 'OK'];
  const _404_NOT_FOUND = ['404_00' => 'Not Found'];

  //Category
  // 200
  const C_LISTED_200_00 = ['C200_00' => 'Categories succesfully listed !'];
  const C_UPDATED_200_01 = ['C200_01' => 'Category succesfully updated !'];
  const C_DELETED_200_02 = ['C200_02' => 'Category succesfully deleted !'];
  const C_GET_200_03 = ['C200_03' => 'Category succesfully retreived !'];
  // 201
  const C_CREATED_201_00 = ['C201_00' => 'Category succesfully created !'];

  //Category
  // 200
  const P_LISTED_200_00 = ['P200_00' => 'Posts succesfully listed !'];
  const P_UPDATED_200_01 = ['P200_01' => 'Post succesfully updated !'];
  const P_DELETED_200_02 = ['P200_02' => 'Post succesfully deleted !'];
  const P_GET_200_03 = ['P200_03' => 'Post succesfully retreived !'];
  // 201
  const P_CREATED_201_00 = ['P201_00' => 'Post succesfully created !'];

  // 200
  const U_LISTED_200_00 = ['U200_00' => 'Users succesfully listed !'];
  const U_UPDATED_200_01 = ['U200_01' => 'User succesfully updated !'];
  const U_DELETED_200_02 = ['U200_02' => 'User succesfully deleted !'];
  const U_GET_200_03 = ['U200_03' => 'User succesfully retreived !'];
  // 201
  const U_CREATED_201_00 = ['U201_00' => 'User succesfully created !'];
}
